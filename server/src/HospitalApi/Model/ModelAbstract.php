<?php

namespace HospitalApi\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

abstract class ModelAbstract 
{

	public $em;
	private $entityPath;

	public function __construct() {
		$this->entityPath = get_class($this->entity);
		$this->entityPath ? 
			$this->em = $this->createEntityManager() : "";
	}

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

	public function insert($obj) {
		$this->em->persist($obj);
		$this->em->flush();
	}

	public function update($obj) {
		$this->em->merge($obj);
		$this->em->flush();
	}

	public function delete($obj) {
		$this->em->remove($obj);
		$this->em->flush();
	}

	public function findById($id) {
		return $this->em->find($this->entityPath, $id);
	}

	public function findAll() {
		$collection = $this->em->getRepository($this->entityPath)->findAll();

		$data = [ ];
		foreach ($collection as $obj) {
			$data[] = $obj;
		}

		return $data;
	}
}
