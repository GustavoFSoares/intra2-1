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
		$id = $req->getQueryParam('id');
		$params = $req->getQueryParams();

		$this->storeUser($params);
		if ($id === null) {
			$results = $this->_model->findBy($params);
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
		$save = true;
		$values = $req->getParsedBody();
		$entity = $this->_mountEntity($values);
		if($entity->canPersist()) {
			$save = $this->_model->doInsert($entity);
		}

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
		$update = true;
		$values = $req->getParsedBody();
		$entity = $this->_mountEntity($values);
		if($entity->canPersist()) {
			$update = $this->_model->doUpdate($entity);
		}
		
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
			$repository
				->setC_Removed(true);
			$delete = $this->_model->doUpdate($repository);
		} else {
			$delete = $this->_model->doDelete($repository);
		}

		return $res->withJson($delete);
	}

	public function uploadFileAction($req, $res, $args) {
		$files = $req->getUploadedFiles();
		$prefix = $req->getParam('prefix');
		$name = $req->getParam('name');

		if(array_key_exists('file', $files)) {
			$file = $files['file'];
			
			$destiny = FILES."{$this->_model->entity->getClassShortName()}/";
			if($prefix) {
				$destiny .= "$prefix/";
			}

			if( !is_dir($destiny) ) {
				mkdir($destiny);
			}
			
			$name = $name ? $name : $file->getClientFilename();
			preg_match_all('/(\.\w{3})$/m', $name, $matches, PREG_SET_ORDER, 0);
			if( isset($matches[0]) ) {
				$fileName = $name;
			} else {
				$extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
				$fileName = $name.$extension;			
			}
			$fileArray = explode('.', $fileName);
			$name = \Helper\SlugHelper::get( $fileArray[0] );
			$extension = $fileArray[1];
			
			$destiny .= "$name.$extension";
			
			$file->moveTo($destiny);
			$response = $destiny;

		} else {
			$res->withCode(401);
			$response = "File Not Found";
		}

		return $res->withJson($response);
	}

	public function getFileByPrefixAction($req, $res, $args) {
        $id = $req->getParam('id');
        $prefix = $req->getParam('prefix');
		
		$model = new \HospitalApi\Model\FileModel();
        $files = $model->getFilesBy($id, $prefix, $this->_model->entity->getClassShortName());
        
        return $res->withJson($files);
	}
	
	public function getFilesOfFolderAction($req, $res, $args) {
		$data = FileController::getFilesOfFolder($this->_model->entity->getClassShortName(), $args['folderId']);

		return $res->withJson($data);
	}

	public function removeFileAction($req, $res, $args) {
		$values = $req->getParsedBody();
		$response = FileController::removeFile($this->_model->entity->getClassShortName(), $values);

        return $res->withJson($response);
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
		$data = is_array($results) ? 
			[] : null;
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
	public function _mountEntity($values){
		$this->loadEntity($values);

		if( method_exists($this->_model, 'mount') ){
			$values = $this->_model->mount($values);
			if(!$values) {
				$this->_model->entity->setLikeError();
			}
		}
		foreach ($values as $key => $value) {
			$method = "set$key";
			$this->_model->entity
				->$method($value);
		}
		return $this->_model->entity;
	}

	public function loadEntity($values) {
		if(isset($values['id']) && $values['id']) {
			$repository = $this->_model->getRepository()->find($values['id']);
			if($repository) {
				$this->_model->entity = $repository;
			}
		}
	}

	public function changeStatusAction($req, $res, $args) {
        $id = $args['id'];
        $entity = $this->_model->changeStatus($id);

        $return = $this->_model->doUpdate($entity);
        return $res->withJson(true);
	}
	
	public function storeUser(&$args) {
		
		if( array_key_exists('user_id', $args) ) {
			$user = $this->_model->em->getRepository('HospitalApi\Entity\User')->find($args['user_id']);
			if($user instanceof \HospitalApi\Entity\User) {
				$this->getContainer()->get('session')->_init($user);
			}
			
			unset($args['user_id']);
		}
	}

	public function gotPermissionAction($req, $res, $args) {
        $params = $req->getQueryParams();
        
        $this->storeUser($params);
        
        $id = isset($params['id']) ? $params['id'] : false;
        $permission = $this->_model->gotPermission($id);
        
        return $res->withJson($permission);
    }
	
}