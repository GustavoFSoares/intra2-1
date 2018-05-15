<?php
namespace HospitalApi\Entity;


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
     * @var Boolean
     *      @Column(type="boolean", options={"default" : false})
     */
    public $c_removed;

    public function __construct() {
        parent::__construct();
        $this->c_removed = false;
    }
}
    