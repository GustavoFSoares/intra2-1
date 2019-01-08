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
     * @var integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String @Column(name="nome", type="string", length=255)
     */
    protected $name;

    /**
     * @var Integer @Column(name="nivel", type="integer", length=255)
     */
    protected $level;

    public function __contruct() {
        parent::__construct();
        $this->id = 0;
        $this->name = null;
        $this->level = 0;
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

    public function getLevel() {
        return $this->level;
    }
    public function setLevel($level) {
        $this->level = $level;
        
        return $this;
    }

}