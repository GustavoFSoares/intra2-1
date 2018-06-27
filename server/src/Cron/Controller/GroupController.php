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

        echo "<b><i>Verificando...</b></i>"."<BR>";
        
        foreach ($groups as $key => $group) {
            $groupId = \Helper\SlugHelper::get($group['name']);
            $mappedGroups[] = $groupId;

            $data = $this->model->findByGroupId($groupId);
            
            if($data) {
                echo "$key - Já Cadastrado - $groupId"."<BR>";
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
                
                echo "$key - <b>Inserido - Grupo $groupId</b>"."<BR>";
                $existingGroups[] = $groupId;
            }
            
        }

        $diffs = array_diff($existingGroups, $mappedGroups);
        echo "<BR><BR>";
        foreach ($diffs as $toDelete) {
            $group = $this->model->findByGroupId($toDelete);
            if($group){
                $this->model->doDelete($group);
                echo "<b>Exluido - Grupo $toDelete</b>"."<BR>";
            }
        }
        
        echo "<b><i>--Atualização de Grupos finalizada--</i></b>";
    }

    public function getModel() {
        return new \HospitalApi\Model\GroupModel();
    }

}