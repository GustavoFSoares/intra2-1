<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Pedido;

class PedidoModel extends ModelAbstract
{

	public $entity;

	public function __construct() {
		$this->entity = new Pedido();
		parent::__construct();
	}
	

}
