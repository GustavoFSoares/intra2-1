<?php

namespace HospitalApi\Controller;

use HospitalApi\Model\EntityAbstract;
use Exception;

abstract class AbstractController 
{
	
	private $model;

	public function __construct($model) {
        if(!$model instanceof EntityAbstract){
            throw new Exception("error");
        }
        $this->model = $model;
	}
	
	public function getModel() {
		return $this->model;
	}
	
	public function get($id) {
		if ($id === null) {
			$data = array ();
			$result = $this->getDao()->findAll ();

			foreach ( $result as $obj ) {
				$data [] = $obj->toArray ();
			}
		} else {
			$obj = $this->getDao ()->findById ( $id );
			if ($obj != null) {

				$data = $obj->toArray ();
			} else
				$data = [];
		}

		return $data;
	}
    abstract public function insert($json);
	abstract public function update($id, $json);
	abstract public function delete($id);
}