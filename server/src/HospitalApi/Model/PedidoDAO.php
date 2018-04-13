<?php

namespace HospitalApi\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use HospitalApi\Entity\Pedido;
use HospitalApi\Model\ModelAbstract;
use HospitalApi\Model\UsuarioDAO;

class PedidoDAO extends AbstractDAO{

public function __construct() {
		parent::__construct('HospitalApi\Entity\Pedido');
	}
	

}
