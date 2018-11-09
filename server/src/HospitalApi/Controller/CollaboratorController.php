<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\CollaboratorModel;

class CollaboratorController extends ControllerAbstractLongEntity
{
    public function __construct() {
        parent::__construct(new CollaboratorModel());
    }

    public function getEmployeeTypes($req, $res, $args) {
        $UserTypeModel = new \HospitalApi\Model\UserTypeModel();
        $collection = $UserTypeModel->findBy();

        $data = $this->translateCollection($collection);
        return $res->withJson($data);
    }

    public function _mountEntity($values){
        foreach ($values as $key => $value) {
			$method = "set$key";
			$this->getModel()->entity
				->$method($value);
		}
        $values = $this->getModel()->mount($this->getModel()->entity);
        
        return $values;
    }

}