<?php

namespace HospitalApi\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use DateTime;

/**
 * <b>ModelAbstract</b>
 * Classe responsável por fazer conexão com BD
 * e inserir métodos de CRUD com banco de dados às
 * outras Models
 */
abstract class ModelAbstract 
{

	public $em;
	public $now;
	protected $entityPath;

	public function __construct() {
		$this->entityPath = get_class($this->entity);
		$this->entityPath ? 
			$this->em = $this->createEntityManager() : "";
		$this->now = new DateTime();
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
	public function doInsert($obj) {
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
	public function doUpdate($obj) {
		$this->em->merge($obj);
		$this->em->flush();
	}

	/**
	 * @method delete()
	 * Recebe um Objeto de Entity, com o objeto que irá ser excluido
	 * @param Entity $obj
	 * @return void
	 */
	public function doDelete($obj) {
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
		$collection = $this->getRepository()->findAll();
		
		return $collection;
	}

	/**
	 * @method getEntityPath()
	 * Retorna o Caminho do Arquivo da model extanciada
	 * @return EntityPath
	 */
	public function getEntityPath() {
		return $this->entityPath;
	}

	/**
	 * @method getRepository()
	 * Retorna uma Representação da Tabela(Model) extanciada
	 * @return Reposotory
	 */
	public function getRepository() {
		return $this->em->getRepository($this->entityPath);
	}

	public function getLogger() {
		$logger = new \Doctrine\DBAL\Logging\DebugStack();
		$logger->enabled;
		$this->em->getConfiguration()->setSQLLogger($logger);

		return $logger;
	}

	/**
	 * @method getNow()
	 * Retorna um Datetime com a Hora Atual
	 * @return Datetime now
	 */
	public function getNow() {
		return $this->now;
	}

	/**
	 * @method isToday()
	 * Verifica se a tada comparada ($matchDate) foi criada
	 * nas ultimas 24 horas. E retorna TRUE se for $diffDays = 0,
	 * Hoje e FALSE para $diffDays diferente de 0
	 * @param Datetime $matchDate
	 * @return boolean
	 */
	public function isToday($matchDate) {
		if($matchDate){
			$diff = $this->now->diff($matchDate);
			$diffDays = (integer)$diff->format("%R%a");
			
			return $diffDays == "0";
		}
	}

}
