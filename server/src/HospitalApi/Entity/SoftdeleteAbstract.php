<?php
namespace HospitalApi\Entity;
use DateTime;

/**
 * <b>SoftdeleteAbstract</b>
 * A Classe Abstrata Softdelete contem o atributo 
 * de remoção lógica. Toda Entidade que extender a Softdelete
 * receberá um Atributo Obrigatório $c_removed Boolean, que 
 * indica se aquele registro deve ser exclúido, mas não apagado da Base de Dados
 */
abstract class SoftdeleteAbstract extends EntityAbstract
{

    /**
     * @var Datetime
     *      @Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    public $c_modified;

    /**
     * @var Boolean
     *      @Column(type="boolean", options={"default" : false})
     */
    public $c_removed;

    public function __construct() {
        parent::__construct();
        $this->c_removed = false;
        $this->c_modified = new DateTime();
    }

    public function setC_modified($c_modified){
        $c_modified = new Datetime();
        
        $this->c_modified = $c_modified;

        return $this;
    }

    public function isRemoved(){
        return $this->c_removed;
    }

    public function setC_removed($c_removed){
        $this->c_removed = $c_removed;

        return $this;
    }
}
    