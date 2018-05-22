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
    public $c_created;

    /**
     * @var Boolean
     *      @Column(type="boolean", options={"default" : false})
     */
    public $c_removed;

    public function __construct() {
        parent::__construct();
        $this->c_removed = false;
        $this->c_created = new DateTime();
    }
}
    