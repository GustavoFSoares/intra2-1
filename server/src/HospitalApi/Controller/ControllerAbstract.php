<?php
namespace HospitalApi\Controller;

use HospitalApi\BasicApplicationAbstract;
use HospitalApi\Entity\SoftdeleteAbstract;
use HospitalApi\Model\ModelAbstract;
use Exception;

/**
 * @abstract <b> ControllerAbstract </b>
 * Classe responsável por incluir métodos básicos de CRUD
 */
abstract class ControllerAbstract extends BasicApplicationAbstract
{
	
	private $_model;

	public function __construct($model) {
		if(!$model instanceof ModelAbstract) {
            throw new Exception("error");
		}
		$this->_model = $model;
	}
	
	public function getModel() {
		return $this->_model;
	}
	
	/**
	 * @method get()
	 * Recebe um Id (opcionalmente) e realiza busca no
	 * Banco de Dados contendo os resultados correspondentes
	 * @param Request $req
	 * @param Response $res
	 * @param Array $args
	 * @return Response $data
	 */
	public function get($req, $res, $args) {
		isset($args['id'])?
			$id = $args['id']:$id = null;
		
		if ($id === null) {
			$results = $this->_model->findAll();
		} else {
			$results = $this->_model->findById($id);
		}
		$data = $this->translateCollection($results);
		
		return $res->withJson($data);
	}

	/**
	 * @method insert()
	 * 
	 * @param Request $req
	 * @param Response $res
	 * @param Array $args
	 * @return void
	 */
	public function insert($req, $res, $args) {
		$values = $req->getParsedBody();
		$this->_mountEntity($values);
		
		$save = $this->_model->doInsert($this_->model->entity);

		return $res->withJson($save);
	}

	/**
	 * @method update()
	 * 
	 * @param Request $req
	 * @param Response $res
	 * @param Array $args
	 * @return void
	 */
	public function update($req, $res, $args) {
		$values = $req->getParsedBody();
		$this->_mountEntity($values);
		
		$update = $this->_model->doUpdate($this_->model->entity);
		
		return $res->withJson($update);
	}

	/**
	 * @method delete()
	 * Recebe um $id e exclui a linha correspondente
	 * @param Request $req
	 * @param Response $res
	 * @param Array $args
	 * @return void
	 */
	public function delete($req, $res, $args) {
		$id = $args['id'];
		$repository = $this->_model->getRepository()->find($id);
		
		if(isset($repository->c_removed)){
			$this->_mountEntity($repository->toArray());
			$this->_model->entity
				->setC_Removed(true);
			$delete = $this->_model->doUpdate($this_->model->entity);
		} else {
			$delete = $this->_model->doDelete($repository);
		}

		return $res->withJson($delete);
	}

	/**
	 * @method translateCollection()
	 * Recebe a busca do Banco de Dados como Objeto
	 * e transforma em Array, para que após seja convertido
	 * em JSON e enviado para o Cliente
	 * @param Collection $results
	 * @return Array $data
	 */
	public function translateCollection($results) {
		$data = null;
		if ($results) {
			if (is_array($results)) {
				foreach ($results as $result) {
					$data[] = $result->toArray();
				}
			} else {
				$data = $results->toArray();
			}
		}
		return $data;
	}

	/**
	 * @method _mountEntity()
	 * Recebe um Array com as informações a serem gravadas
	 * e insere no objeto da entidade
	 * @param Array $values
	 * @return void
	 */
	private function _mountEntity($values){
		foreach ($values as $key => $value) {
			$method = "set$key";
			$this->_model->entity
				->$method($value);
		}
	}
	
}