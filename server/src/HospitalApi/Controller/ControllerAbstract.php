<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\ModelAbstract;
use Exception;

/**
 * @abstract <b> ControllerAbstract </b>
 * Classe responsável por incluir métodos básicos de CRUD
 */
abstract class ControllerAbstract
{
	
	private $model;

	public function __construct($model) {
		if(!$model instanceof ModelAbstract) {
            throw new Exception("error");
		}
		$this->model = $model;
	}
	
	public function getModel() {
		return $this->model;
	}
	
	/**
	 * @method get()
	 * Recebe um Id (opcionalmente) e realiza busca no
	 * Banco de Dados contendo os resultados correspondentes
	 * @param Request $req
	 * @param Response $res
	 * @param Args $args
	 * @return Response $data
	 */
	public function get($req, $res, $args) {
		isset($args['id'])?
			$id = $args['id']:$id = null;
		
		if ($id === null) {
			$results = $this->model->findAll();
		} else {
			$results = $this->model->findById($id);
		}
		$data = $this->translateCollaction($results);
		
		return $res->withJson($data);
	}

	public function translateCollaction($results){
		$data = null;
		if($results){
			if(is_array($results)){
				foreach ($results as $result) {
					$data[] = $result->toArray();
				}
			} else {
				$data = $results->toArray();	
			}
		}
		return $data;
	}

    public function insert($json) { }
	public function update($id, $json) { }
	public function delete($id) { }
}