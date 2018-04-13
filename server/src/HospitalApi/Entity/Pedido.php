<?php
namespace HospitalApi\Entity;

use HospitalApi\Entity\EntityAbstract;

/**
 * @Entity
 * @Table(name="pedido")
 */
class Pedido extends EntityAbstract{

  /**
  *	@var integer @Id
  *      @Column(name="id", type="integer")
  *      @GeneratedValue(strategy="AUTO")
  */
private $id;
/**
 * @Column(type="datetime")
 * @var DateTime
 */
private $hora;

/**
	 * @ManyToOne(targetEntity="Usuario",cascade={"persist"})
	 * @JoinColumn(name="usuario_id", referencedColumnName="id")
	 */
private $usuario;

public function __construct($id = 0,$hora = null,$usuario = 0){
$this->id = $id;
$this->hora = $hora;
$this->usuario = $usuario;

}

public static function construct($array){
$obj = new Pedido();
$obj->setId( $array['id']);
$obj->setHora( $array['hora']);
$obj->setUsuario( $array['usuario']);
return $obj;

}

public function getId(){
return $this->id;
}

public function setId($id){
 $this->id=$id;
}

public function getHora(){
return $this->hora;
}

public function setHora($hora){
 $this->hora=$hora;
}

public function getUsuario(){
return $this->usuario;
}

public function setUsuario($usuario){
 $this->usuario=$usuario;
}

public function equals($object){
if($object instanceof Pedido){

if($this->id!=$object->id){
return false;

}

if($this->hora!=$object->hora){
return false;

}

if($this->usuario!=$object->usuario){
return false;

}

return true;

}
else{
return false;
}

}
public function toString(){

 return "  [id:" .$this->id. "]  [hora:" .$this->hora. "]  [usuario:" .$this->usuario. "]" ;
}

 public function toArray(){
   return [
  "id"=>$this->id,
   "hora"=>$this->hora,
   "usuario"=>$this->usuario->toArray(),
   ];
 }

}
