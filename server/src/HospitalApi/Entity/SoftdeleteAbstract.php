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
     * @var Datetime
     *      @Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $c_created;

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
        $this->c_removed = (Boolean)$c_removed;

        return $this;
    }

    public function setC_created($c_created) { }

    /**
    * @\Doctrine\ORM\Mapping\preUpdate
    */
    public function set() {
        $select = $this->getEntityManager()->createQueryBuilder();
        $select->select('t.c_created')
            ->from($this->getClassName(), 't')
            ->where("t.id = '{$this->id}'");
        $data = $select->getQuery()->getOneOrNullResult();
        
        $this->c_created = $data['c_created'];
    }
    
    /**
    * @\Doctrine\ORM\Mapping\prePersist
    */
    public function newInsert() {
        $this->c_created = new DateTime();
    }

}