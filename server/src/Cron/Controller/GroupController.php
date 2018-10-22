<?php
namespace Cron\Controller;

use HospitalApi\BasicApplicationAbstract;
use HospitalApi\Controller\ActiveDirectoryController;
use HospitalApi\Entity\Group;
use Cocur\Slugify\Slugify;
/**
 * <b>ActiveDirectoryController</b>
 */
class GroupController extends BasicApplicationAbstract
{

    public $model;
    public function __construct(){
        $this->model = new \Cron\Model\GroupModel();
    }

    public function update() {
        $AD = new ActiveDirectoryController();
        $alph = ['a', 'b', 'c', 'd', 'e', 'f',
        		 'g', 'h', 'i', 'j', 'k', 'l',
        		 'm', 'n', 'o', 'p', 'q', 'r',
        		 's', 't', 'u', 'v', 'w', 'x',
                 'y', 'z', '.'
        ];
            
        \Helper\LoggerHelper::initLogFile('cron/group', null, 'GROUP', 'Y/m/d his');
        echo \Helper\LoggerHelper::writeFile("Verificando...\n");
        
        $mappedGroups = $this->model->findGroupsId();
        $existingGroups = '';
        $count = 0;
        
        foreach ($alph as $letter) {
            foreach ($alph as $secondLetter) {
                $groups = $AD->getGroups($letter.$secondLetter);
 
        
                foreach ($groups as $key => $group) {
                    $groupId = \Helper\SlugHelper::get($group['name']);
                    
                    $data = $this->model->findByGroupId($groupId);
            
                    if($data) {
                        $data
                            ->setName($group['name'])
                            ->setEnterprise(
                                $group['enterprise'] ? $group['enterprise'] : $group['name']
                            )
                            ->setC_removed(false);
                        $this->model->doUpdate($data);
                        
                        echo \Helper\LoggerHelper::writeFile("$count - Atualizado - $groupId\n");
                        $existingGroups[] = $groupId;
                    } else {
                        $newGroup = new Group();
                    
                        $newGroup
                            ->setGroupId(\Helper\SlugHelper::get($group['name']))
                            ->setName($group['name'])
                            ->setEnterprise(
                                $group['enterprise'] ? $group['enterprise'] : $group['name']
                            )
                            ->setC_removed(false);
                        $this->model->doInsert($newGroup);
                        
                        echo \Helper\LoggerHelper::writeFile("$count - Inserido - Grupo $groupId\n");
                        $existingGroups[] = $groupId;
                    }
                    
                    $count++;
                }

            }
        }
        
        $diffs = \Helper\Differ::diff($existingGroups, $mappedGroups);

        \Helper\LoggerHelper::writeFile("\n");
        foreach ($diffs as $toDelete) {
            $group = $this->model->findByGroupId($toDelete);
            if($group){
                $group->setC_removed(true);
                $this->model->doUpdate($group);
                echo \Helper\LoggerHelper::writeFile("Exluido - Grupo $toDelete\n");
            }
        }
        
        \Helper\LoggerHelper::writeFile("--Atualizacao de Grupos finalizada--\n");
    }

    public function getModel() {
        return new \HospitalApi\Model\GroupModel();
    }

}