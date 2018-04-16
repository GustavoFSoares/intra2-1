<?php
namespace HospitalApi\Entity;


abstract class EntityAbstract
{
    // private $classVars;
    
    public function __construct() {

    }

    public function getClassName() {
        return get_class($this);
    }

    public function getClassVars()
    {
        return get_class_vars($this->getClassName());
    }

    public function toString(){
        $obj;
        foreach ($this->getClassVars() as $var => $value) {
            $obj.="[$var:".$this->$var."]";
        }
        return $obj;
    }

    public function toArray(){
        $obj;
        foreach ($this->getClassVars() as $var => $value) {
            $obj[$var] = $this->$var;
        }
        return $obj;
    }

}
