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

    public function getUnrealized($req, $res, $args) {
        $collection = $this->getModel()->getUnrealized();
        $data = $this->translateCollection($collection);

        return $res->withJson($data);
    }
    
    public function isDone($req, $res, $args) {
        $id = $args['id'];
        
        $return = $this->getModel()->isDone($id);
        return $res->withJson($return);
    }

    public function _mountEntity($values){
        $entity = $this->getModel()->mount($values);
        return parent::_mountEntity($entity);
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