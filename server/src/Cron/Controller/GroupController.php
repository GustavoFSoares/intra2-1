<?php
namespace Cron\Controller;

use HospitalApi\Controller\ActiveDirectoryController;
use HospitalApi\Entity\Group;
use Cocur\Slugify\Slugify;
/**
 * <b>ActiveDirectoryController</b>
 */
class GroupController
{

    public $model;
    public function __construct(){
        $this->model = new \Cron\Model\GroupModel();
    }

    public function update() {
        $AD = new ActiveDirectoryController();
        $groups = $AD->getGroups();

        $mappedGroups = $this->model->findGroupsId();
        $existingGroups = '';
        \Helper\LoggerHelper::initLogFile('group');
        \Helper\LoggerHelper::writeFile("Verificando...\n");
        
        foreach ($groups as $key => $group) {
            $groupId = \Helper\SlugHelper::get($group['name']);
            
            $data = $this->model->findByGroupId($groupId);
            
            if($data) {
                \Helper\LoggerHelper::writeFile("$key - Ja Cadastrado - $groupId\n");
                $existingGroups[] = $groupId;
            } else {
                $newGroup = new Group();
            
                $newGroup
                    ->setGroupId(\Helper\SlugHelper::get($group['name']))
                    ->setName($group['name'])
                    ->setEnterprise(
                        $group['enterprise'] ? $group['enterprise'] : $group['name']
                    );
                $this->model->doInsert($newGroup);
                
                \Helper\LoggerHelper::writeFile("$key - Inserido - Grupo $groupId\n");
                $existingGroups[] = $groupId;
            }
            
        }

        $diffs = \Helper\Differ::diff($existingGroups, $mappedGroups);

        \Helper\LoggerHelper::writeFile("\n");
        foreach ($diffs as $toDelete) {
            $group = $this->model->findByGroupId($toDelete);
            if($group){
                $this->model->doDelete($group);
                \Helper\LoggerHelper::writeFile("Exluido - Grupo $toDelete\n");
            }
        }
        
        \Helper\LoggerHelper::writeFile("--Atualizacao de Grupos finalizada--\n");
    }

    public function getModel() {
        return new \HospitalApi\Model\GroupModel();
    }

}