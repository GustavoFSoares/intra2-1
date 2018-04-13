<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Usuario;

class UsuarioModel extends ModelAbstract
{
	public $entity;

	public function __construct() {
		$this->entity = new Usuario();
		parent::__construct();
	}


}
