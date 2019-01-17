<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @\Doctrine\ORM\Mapping\HasLifecycleCallbacks
 * @Table(name="Documento_Eletronico_Assinatura")
 * <b>EletronicDocumentSignature</b>
 */
class EletronicDocumentSignature extends EntityAbstract
{
    
    /**
     * @var integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="usuario_id", referencedColumnName="id" )
     */
    protected $user;

    /**
     * @var Boolean @Column(name="ac", type="boolean", options={ "default": false })
     */
    protected $bc;
    
    /**
     * @var Boolean @Column(name="assinatura", type="boolean", options={ "default": false })
     */
    protected $signed;

    /**
     * @ManyToOne(targetEntity="EletronicDocument", inversedBy="userList")
     * @JoinColumn(name="documento_id", referencedColumnName="id")
     */
    protected $document;

    public function __construct($id = 0, $user = null, $bc = false, $signed = false, $document = null) {
        parent::__construct();
        $this->id = $id;
        $this->user = $this->setUser($user);
        $this->bc = $bc;
        $this->signed = $signed;
        $this->document = $document;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        
        return $this;
    }
    
    public function getUser() {
        return $this->user;
    }
    public function setUser($user) {
        $this->user =  $this->getRepositoryOf('User', $user);
        
        return $this;
    }

    public function getBc() {
        return $this->bc;
    }
    public function isBc() {
        $this->getBc();
    }
    public function setBc($bc) {
        $this->bc =  $bc ? true : false;
        
        return $this;
    }
    
    public function getSigned() {
        return $this->signed;
    }
    public function isSigned() {
        $this->getSigned();
    }
    public function setSigned($signed) {
        $this->signed =  $signed ? true : false;
        
        return $this;
    }
    
    public function getDocument() {
        return $this->document;
    }
    public function setDocument($document) {
        $this->document = $this->getRepositoryOf('EletronicDocument', $document);
        
        return $this;
    }

}