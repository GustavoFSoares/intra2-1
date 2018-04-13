<?php
namespace HospitalApi\Entity;


abstract class EntityAbstract
{
    private $classVars;
    
    public function __construct() {
        $className = get_class($this);
        $this->classVars = get_class_vars($className);

        unset($this->classVars['classVars']);
    }

    public function getClassName() {
        return get_class($this);
    }

    public function toString(){
        $obj;
        foreach ($this->classVars as $var => $value) {
            $obj.="[$var:".$this->$var."]";
        }
        return $obj;
    }

    public function toArray(){
        $obj;
        foreach ($this->classVars as $var => $value) {
            $obj[$var] = $this->$var;
        }
        return $obj;
    }

}
