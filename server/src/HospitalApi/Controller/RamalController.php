<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\RamalModel;

/**
 * <b>RamalController</b>
 */
class RamalController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new RamalModel());
    }

    public function findAll($req, $res, $args) {
        $collection = $this->getModel()->findAll($args);
        
        $data = $this->translateCollection($collection);
        return $res->withJson($data);
    }

    public function _mountEntity($values){
        $model = $this->getModel();
        
        $values = $model->mount($values);

        return parent::_mountEntity($values);
    }

    public function filter($req, $res, $args) {
        $filter = $args['filter'];
        $collection = $this->getModel()->filterRamals($filter);

        $data = $this->translateCollection($collection);
        return $res->withJson($data);
    }

    public function delete($req, $res, $args) {
        $id = $args['id'];
        $model = $this->getModel();
        
        $repository = $model->getRepository()->find($id);
        $repository->setGroup(null);

        $delete = $model->doDelete($repository);
        return $res->withJson($delete);
    }

    public function changeStatus($req, $res, $args) {
        $id = $args['id'];
        $model = $this->getModel();

		$repository = $model->getRepository()->find($id);
		$repository
			->setC_Removed(!$repository->isRemoved());
        
        $delete = $model->doUpdate($repository);
        return $res->withJson(true);
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
                        $method = "get$key";
        
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