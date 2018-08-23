<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\ModuleModel;

class ModuleController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new ModuleModel());
    }

    public function getModulesByGroup($req, $res, $args) {
        $group = $args['group'];
        
        $model = $this->getModel();
        $data = $model->findByGroup($group);

        $collection = $this->translateCollection($data);
        return $res->withJson($collection);
    }

    public function insertChield($req, $res, $args) {
        $values = $req->getParsedBody();
        $model = $this->getModel();

        $entity = $model->mount($values);
        $model->doInsert($entity);

        return $res->withJson(true);
    }

    public function updateChield($req, $res, $args) {
        $values = $req->getParsedBody();
        $model = $this->getModel();

        $entity = $model->mount($values);
        $model->doUpdate($entity);

        return $res->withJson(true);
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

    public function delete($req, $res, $args) {
        $id = $args['id'];
        $model = $this->getModel();
		$repository = $model->getRepository()->find($id);
		$delete = $model->doDelete($repository);

		return $res->withJson($delete);
    }

    public function removeChield($req, $res, $args) {
        $chieldId = $args['id'];
        
        $model = $this->getModel();
        $chield = $model->removeChield($chieldId);

		$model->doUpdate($chield);

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

    public function translateCollection($collection) {
        $groups = [];
        $children = [];
        if (is_array($collection)) {
            foreach ($collection as &$row) {
                
                foreach ($row->getGroups()->toArray() as $groupRow) {
                    $groups[$groupRow->getGroupId()] = $groupRow->toArray();
                }

                foreach ($row->getChildren()->toArray() as $chieldRow) {
                    $children[] = $chieldRow->toArray();
                }
                $row->setGroups($groups);
                $row->setChildren($children);
                $row->getParent() ? $row->setParent($row->getParent()->toArray()) : "";
                
                $groups = [];
                $children = [];
            }
        } else {
            foreach ($collection->getGroups()->toArray() as $groupRow) {
                $groups[$groupRow->getGroupId()] = $groupRow->toArray();
            }
            
            foreach ($collection->getChildren()->toArray() as $chieldRow) {
                $children[] = $chieldRow->toArray();
            }
            $collection->setGroups($groups);
            $collection->setChildren($children);
            $collection->getParent() ? $collection->setParent($collection->getParent()->toArray()) : "";
        }
        
        return parent::translateCollection($collection);
    }

    public function changeStatus($req, $res, $args) {
        $id = $args['id'];
        $model = $this->getModel();

        $repository = $model->getRepository()->find($id);
        $repository
            ->setC_removed(!$repository->isRemoved());
        
        $update = $model->doUpdate($repository);
        
        return $res->withJson($update);
    }

    public function _mountEntity($result) {
        $entity = parent::_mountEntity($result);
        $entity->setParent(null);

        return $entity;
    }
}