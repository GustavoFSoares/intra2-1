<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\ModuleModel;

class ModuleController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new ModuleModel());
    }

    public function insertGroup($req, $res, $args) {
        $values = (object)$req->getParsedBody();
        $model = $this->getModel();
        
        $module = $model->getRepository()->find($values->module);

        $group = $model->em->find('HospitalApi\Entity\Groups', $values->group);
        $module->addGroup($group);
        $model->doInsert($module);

        return $res->withJson(true);
    }

    public function getModulesByGroup($req, $res, $args) {
        $group = $args['group'];
        
        $model = $this->getModel();
        $data = $model->findByGroup($group);
        
        foreach ($data as $row) {
            $result[] = $row->toArray();
        }
        return $res->withJson($result);
    }

    public function translateCollection($collection) {
        if (is_array($collection)) {
            foreach ($collection as &$row) {
                $groups = [];
                
                foreach ($row->getGroups()->toArray() as $groupRow) {
                    $groups[] = $groupRow->toArray();
                }
                $row = $row->setGroups($groups);
            }
        } else {
            foreach ($collection->getGroups()->toArray() as $groupRow) {
                $groups[] = $groupRow->toArray();
            }
            $collection = $collection->setGroups($groups);
        }
        
        return parent::translateCollection($collection);
    }
}