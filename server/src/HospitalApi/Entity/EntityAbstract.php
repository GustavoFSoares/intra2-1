<?php
namespace HospitalApi\Entity;

use HospitalApi\BasicApplicationAbstract;
use Datetime;
/**
 * @abstract EntityAbstract
 * <b>EntityAbstract</b>
 * Classe Abstrata das Entidades. Responsável
 * pela abstração e implementação de métodos 
 * como <i>toArray()</i> e <i>toString()</i>
 */
abstract class EntityAbstract extends BasicApplicationAbstract
{
    
    public function __construct() { }

    /**
     * @method getClassName()
     * Retorna uma string com nome da classe 
     * com nome da classe atual<i>($this)</i>
     * @return String NomeClase
     */
    public function getClassName() {
        return get_class($this);
    }

    /**
     * @method getClassVars()
     * Retorna um array contendo o nome dos 
     * atributos da classe atual<i>($this)</i>
     * @return Array vars
     */
    public function getClassVars()
    {
        return get_class_vars($this->getClassName());
    }

    /**
     * @method toString()
     * Retorna uma String no formato de chave:valor
     * contendo os o nome do atributo e valor associado a ele
     * @return String atributos
     */
    public function toString() {
        $obj;
        foreach ($this->getClassVars() as $var => $value) {
            $obj.="[$var:".$this->$var."]";
        }
        return $obj;
    }

    /**
     * @method toArray()
     * Restorna um Array no formato de chave => valor
     * contendo o nome do atributo e valor associado a ele
     * @return Array atributos
     */
    public function toArray() {
        $obj;
        foreach ($this->getClassVars() as $var => $value) {
            if($var != 'lazyPropertiesDefaults')
                $obj[$var] = $this->$var ? $this->$var : "";
        }
        return $obj;
    }

    public function convertToDatetime($date) {
        if (!$date instanceof Datetime) {
            $search = [' ', '-', '/'];
            $reclace = ['', ' ', '-'];
            $date = str_replace($search, $reclace, $date);
            $date = new DateTime($date);
        }
        return $date;
    }

    /**
     * @method _formatDate()
     * Recebe data no formato d/m/Y H:m:s e
     * retorna no Formato MySql Y-m-d H:i:s
     * @return Date
     */
    public function _formatDate($date){
        if(!($date instanceof \DateTime)) {
            $search = [' ', '-', '/'];
            $reclace = ['', ' ', '-'];
            $date = str_replace($search, $reclace, $date);
            
            $date = date("Y-m-d H:i:s", strtotime($date));
            $date = DateTime::createFromFormat("Y-m-d H:i:s", $date);
        }
        return $date;
    }

}
