<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\TrainingModel;

/**
 * <b>TrainingController</b>
 */
class TrainingController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new TrainingModel());
    }

    public function insert($req, $res, $args){
        $values = $req->getParsedBody();
        
        $model = $this->getModel();
        
        $entity = $model->mount($values);
        $model->doInsert($entity);
        
        return $res->withJson(true);
    }

    public function _mountEntity($values){
        $model = $this->getModel();
        
        $entity = $model->mount($values);
        return $entity;
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
                foreach ($entity->toArray() as $key => $value) {
                    
                    if($value instanceof \HospitalApi\Entity\EntityAbstract){
                        $arr[$key] = $this->translateCollection($value);
        
                    } else {
                        $method = "get$key";
        
                        if(method_exists($entity, $method)) {
                            $result = $entity->$method();
        
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