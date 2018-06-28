<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\ModuleModel;

class ModuleController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new ModuleModel());
    }

    public function updateGroups($req, $res, $args) {
        $values = $req->getParsedBody();
        
        $model = $this->getModel();
        foreach ($values as $value) {
            
            $module = $model->getRepository()->find($value['module']);
            $group = $model->em->find('HospitalApi\Entity\Group', $value['group']);
            
            if($value['active']){
                $module->addGroup($group);
                $model->doInsert($module);
            } else {
                $module->removeGroup($group);
                $model->doUpdate($module);
            }
        }

        return $res->withJson(true);
    }

    public function deleteGroups($req, $res, $args) {
        $values = $req->getParsedBody();
    
        $model = $this->getModel();
        foreach ($values as $value) {
            $module = $model->getRepository()->find($value['module']);
            $group = $model->em->find('HospitalApi\Entity\Groups', $value['group']);
            $module->removeGroup($group);
            $model->doUpdate($module);
        }

        return $res->withJson(true);
    }

    public function getModulesByGroup($req, $res, $args) {
        $group = $args['group'];
        
        $model = $this->getModel();
        $data = $model->findByGroup($group);

        $collection = $this->translateCollection($data);
        return $res->withJson($collection);
    }

    public function translateCollection($collection) {
        if (is_array($collection)) {
            foreach ($collection as &$row) {
                $groups = [];
                
                foreach ($row->getGroups()->toArray() as $groupRow) {
                    $groups[$groupRow->getGroupId()] = $groupRow->toArray();
                }
                $row = $row->setGroups($groups);
            }
        } else {
            foreach ($collection->getGroups()->toArray() as $groupRow) {
                $groups[$groupRow->getGroupId()] = $groupRow->toArray();
            }
            $collection = $collection->setGroups($groups);
        }
 
        return parent::translateCollection($collection);
    }
}