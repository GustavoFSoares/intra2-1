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
        
        $mappedGroups = '';
        $existingGroups = '';

        echo "Verificando...\n";
        
        foreach ($groups as $key => $group) {
            $groupId = \Helper\SlugHelper::get($group['name']);
            $mappedGroups[] = $groupId;

            $data = $this->model->findByGroupId($groupId);
            
            if($data) {
                echo "$key - Ja Cadastrado - $groupId\n";
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
                
                echo "$key - Inserido - Grupo $groupId\n";
                $existingGroups[] = $groupId;
            }
            
        }

        $diffs = array_diff($existingGroups, $mappedGroups);
        echo "\n";
        foreach ($diffs as $toDelete) {
            $group = $this->model->findByGroupId($toDelete);
            if($group){
                $this->model->doDelete($group);
                echo "Exluido - Grupo $toDelete\n";
            }
        }
        
        echo "--Atualizacao de Grupos finalizada--\n";
    }

    public function getModel() {
        return new \HospitalApi\Model\GroupModel();
    }

}