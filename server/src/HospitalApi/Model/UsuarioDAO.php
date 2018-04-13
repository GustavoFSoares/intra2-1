<?php

namespace HospitalApi\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use HospitalApi\Model\AbstractDAO;
use HospitalApi\Entity\Usuario;

class UsuarioDAO extends AbstractDAO{

public function __construct() {
		parent::__construct('HospitalApi\Entity\Usuario');
	}


}
