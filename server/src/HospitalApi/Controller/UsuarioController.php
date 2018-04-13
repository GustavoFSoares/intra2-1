<?php

namespace HospitalApi\Controller;

use HospitalApi\Model\UsuarioDAO;
use HospitalApi\Entity\Usuario;
use HospitalApi\Controller\AbstractController;

class UsuarioController extends AbstractController {

	public function __construct() {
    parent::__construct(new UsuarioDAO ());
	}


	public function insert($json){
    $user = new Usuario($json->id,$json->email,$json->senha,$json->endereco);
    $this->getDao ()->insert ( $user );
    return ["mensagem"=>"Usuario inserido com sucesso"];
	}
	
	public function update($id, $json){
		
	}
	public function delete($id){
		
	}
}
