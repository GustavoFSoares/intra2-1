<?php

namespace HospitalApi\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * <b>ModelAbstract</b>
 * Classe responsável por fazer conexão com BD
 * e inserir métodos de CRUD com banco de dados às
 * outras Models
 */
abstract class ModelAbstract 
{

	public $em;
	protected $entityPath;

	public function __construct() {
		$this->entityPath = get_class($this->entity);
		$this->entityPath ? 
			$this->em = $this->createEntityManager() : "";
	}

	/**
	 * @method createEntityManager()
	 * Configura conexões com Banco de Dados e indica caminho
	 * das pastas das Entidades, onde realizará o mapeamento 
	 * para o próprio Banco. 
	 * Retorna um EntityManager com os métodos do Doctrine
	 * @return EntityManager
	 */
	public function createEntityManager() {

		$path = ['HospitalApi\Entity'];
		$devMode = true;

		$config = Setup::createAnnotationMetadataConfiguration($path, $devMode);

		$connectionOptions = [
			'dbname' => 'hospital_api',
			'user' => 'root',
			'password' => 'root',
			'host' => 'mysql',
			'driver' => 'pdo_mysql'
		];

		return EntityManager::create($connectionOptions, $config);
	}

	/**
	 * @method insert()
	 * Recebe um Objeto de Entity, contendo os valores que irão
	 * ser inseridos
	 * @param Entity $obj
	 * @return void
	 */
	public function insert($obj) {
		$this->em->persist($obj);
		$this->em->flush();
	}

	/**
	 * @method update()
	 * Recebe um Objeto de Entity, contendo os valores alterados
	 * e o Id do objeto original, quer irá ser atualizado
	 * @param Entity $obj
	 * @return void
	 */
	public function update($obj) {
		$this->em->merge($obj);
		$this->em->flush();
	}

	/**
	 * @method delete()
	 * Recebe um Objeto de Entity, com o objeto que irá ser excluido
	 * @param Entity $obj
	 * @return void
	 */
	public function delete($obj) {
		$this->em->remove($obj);
		$this->em->flush();
	}

	/**
	 * @method findById()
	 * Recebe um <i>Id</i> e realiza uma busca no banco e retorna
	 * um Array contendo o correspondente.
	 * @param Integer $id
	 * @return Array
	 */
	public function findById($id) {
		return $this->em->find($this->entityPath, $id);
	}

	/**
	 * @method findAll()
	 * Retorna uma Array com os resultados da tabela no Banco de Dados
	 * @return Array 
	 */
	public function findAll() {
		$collection = $this->em->getRepository($this->entityPath)->findAll();
		
		return $collection;
	}


	public function getEntityPath(){
		return $this->entityPath;
	}

	public function getLogger() {
		$logger = new \Doctrine\DBAL\Logging\DebugStack();
		$logger->enabled;
		$this->em->getConfiguration()->setSQLLogger($logger);

		return $logger;
	}
}
