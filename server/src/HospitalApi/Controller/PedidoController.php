<?php

namespace HospitalApi\Controller;

use HospitalApi\Model\PedidoDAO;
use HospitalApi\Entity\Pedido;
use HospitalApi\Entity\Item;
use HospitalApi\Entity\Usuario;
use HospitalApi\Controller\AbstractController;
use DateTime;

class PedidoController extends AbstractController{

public function __construct() {
    parent::__construct(new PedidoDAO ());
	}
	
	public function insert($json){
	$itens = array();
	
	foreach($json->itens as $item){
		$i = new Item();
		$i->setQuantidade($item->quantidade);
		$i->setProduto($item->produto);
		$items[] = $i;	
	}
	
	$user = new Usuario($json->usuarioId);
	$hora = new DateTime("now");
	$pedido = new Pedido(0,$hora,$user,$itens);
    
    $this->getDao ()->insert ( $pedido );
    return array("sucess"=>"true","input"=>$json);
	}
	public function update($id, $json){}
	public function delete($id){}
}
