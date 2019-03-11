<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @\Doctrine\ORM\Mapping\HasLifecycleCallbacks
 * @Table(name="Documento_Eletronico_Status")
 * <b>EletronicDocumentStatus</b>
 */
class EletronicDocumentStatus extends SoftdeleteAbstract
{
    
    /**
     * @var String @Id
     *     @Column(name="id", type="string")
     */
    protected $id;

    /**
     * @var String @Column(name="nome", type="string", length=255)
     */
    protected $name;

    /**
     * @var Integer @Column(name="ordem", type="integer", length=255)
     */
    protected $order;

    public function __construct() {
        parent::__construct();
        $this->id = 0;
        $this->name = null;
        $this->order = 0;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        
        return $this;
    }
    
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
        
        return $this;
    }

    public function getOrder() {
        return $this->order;
    }
    public function setOrder($order) {
        $this->order = $order;
        
        return $this;
    }

}