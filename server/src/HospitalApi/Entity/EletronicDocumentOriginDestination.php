<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @\Doctrine\ORM\Mapping\HasLifecycleCallbacks
 * @Table(name="Documento_Eletronico_Origem_Destino")
 * <b>EletronicDocumentOriginDestination</b>
 */
class EletronicDocumentOriginDestination extends EntityAbstract
{
    
    /**
     * @var integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Group")
     * @JoinColumn(name="grupo_id_origem", referencedColumnName="id")
     */
    protected $originGroup;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="usuario_id_origem", referencedColumnName="id", nullable=true)
     */
    protected $originUser;
    
    /**
     * @ManyToOne(targetEntity="Group")
     * @JoinColumn(name="grupo_id_destino", referencedColumnName="id")
     */
    protected $destinationGroup;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="usuario_id_destino", referencedColumnName="id", nullable=true)
     */
    protected $destinationUser;

    /**
     * @OneToOne(targetEntity="EletronicDocument", inversedBy="originDestination", cascade={"persist", "remove"})
     * @JoinColumn(name="documento_eletronico_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $eletronicDocument;

    public function __contruct() {
        parent::__construct();
        $this->id = 0;
        $this->originGroup = '';
        $this->originUser = null;
        $this->destinationGroup = '';
        $this->destinationUser = null;
        $this->eletronicDocument = null;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        
        return $this;
    }
    
    public function getOriginGroup() {
        return $this->originGroup;
    }
    public function setOriginGroup($originGroup) {
        $this->originGroup =  $this->getRepositoryOf('Group', $originGroup);
        
        return $this;
    }

    public function getOriginUser() {
        return $this->originUser;
    }
    public function setOriginUser($originUser) {
        $this->originUser =  $this->getRepositoryOf('User', $originUser);
        
        return $this;
    }

    public function getDestinationGroup() {
        return $this->destinationGroup;
    }
    public function setDestinationGroup($destinationGroup) {
        $this->destinationGroup =  $this->getRepositoryOf('Group', $destinationGroup);
        
        return $this;
    }
    
    public function getDestinationUser() {
        return $this->destinationUser;
    }
    public function setDestinationUser($destinationUser) {
        $this->destinationUser =  $this->getRepositoryOf('User', $destinationUser);
        
        return $this;
    }
    
    public function getEletronicDocument() {
        return $this->eletronicDocument;
    }
    public function setEletronicDocument($eletronicDocument) {
        $this->eletronicDocument =  $this->getRepositoryOf('EletronicDocument', $eletronicDocument);
        
        return $this;
    }

}