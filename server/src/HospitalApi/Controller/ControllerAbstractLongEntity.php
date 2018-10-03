<?php
namespace HospitalApi\Controller;

abstract class ControllerAbstractLongEntity extends ControllerAbstract
{
    
    public function __construct($model) {
        parent::__construct($model);
    }

    public function _mountEntity($values) {
        $data = $this->getModel()->mount($values);
        return parent::_mountEntity($data);
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