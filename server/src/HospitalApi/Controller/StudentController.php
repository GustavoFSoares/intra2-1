<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\StudentModel;

class StudentController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new StudentModel());
    }

    public function getEmployeeTypes($req, $res, $args) {
        $UserTypeModel = new \HospitalApi\Model\UserTypeModel();
        $collection = $UserTypeModel->findAll();

        $data = $this->translateCollection($collection);
        return $res->withJson($data);
    }

    public function _mountEntity($values){
        $entity = parent::_mountEntity($values);
        $values = $this->getModel()->mount($entity);
        
        return $values;
    }

    public function translateCollection($entity) {
        if(empty($arr)){
			$arr = is_array($entity) ? 
				[] : null;
        }
        
        if($entity) {
            if(is_array($entity)){
                foreach ($entity as $key => $value) {
                    $arr[$key] = $this->translateCollection($value);
                }
            } else {
                $arrayEntity = $entity->toArray();
                foreach ($arrayEntity as $key => $value) {
                    if($value instanceof \HospitalApi\Entity\EntityAbstract){
                        $arr[$key] = $this->translateCollection($value);
        
                    } else {
                        if(array_key_exists($key, $entity->toArray())) {
                            $result = $value;
        
                            if(method_exists($result, "toArray")) {
        
                                foreach ($result->toArray() as $k => $val) {
                                    $arr[$key][$k] = $this->translateCollection($val);
                                }
                                
                            } else {
                                $arr[$key] = $value;
                            }
                        }
                    }
        
                }
                
            }
        }
        return $arr;
    }
}