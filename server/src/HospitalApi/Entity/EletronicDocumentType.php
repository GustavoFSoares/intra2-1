<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @\Doctrine\ORM\Mapping\HasLifecycleCallbacks
 * @Table(name="Documento_Eletronico_Tipo")
 * <b>EletronicDocumentType</b>
 */
class EletronicDocumentType extends SoftdeleteAbstract
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
     * @var String @Column(name="codigo", type="integer", length=255)
     */
    protected $code;

    public function __contruct() {
        parent::__construct();
        $this->id = 0;
        $this->name = null;
        $this->code = 0;
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

    public function getCode() {
        return $this->code;
    }
    public function setCode($code) {
        $this->code = $code;
        
        return $this;
    }

}