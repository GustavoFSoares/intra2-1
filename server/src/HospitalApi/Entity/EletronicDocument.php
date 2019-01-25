<?php
namespace HospitalApi\Entity;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @\Doctrine\ORM\Mapping\HasLifecycleCallbacks
 * @Table(name="Documento_Eletronico")
 * <b>EletronicDocument</b>
 */
class EletronicDocument extends SoftdeleteAbstract
{
    
    /**
     * @var integer @Id
     *     @Column(name="id", type="string")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="usuario_id", referencedColumnName="id" )
     */
    protected $user;

    /**
     * @ManyToOne(targetEntity="EletronicDocumentType")
     * @JoinColumn(name="tipo_id", referencedColumnName="id")
     */
    protected $type;

    /**
     * @OrderBy({ "user" = "ASC" })
     * @OneToMany(targetEntity="EletronicDocumentSignature", mappedBy="_document", cascade={"persist", "remove"})
     */
    protected $signatureList;

    /**
     * @ManyToOne(targetEntity="EletronicDocumentStatus")
     * @JoinColumn(name="status_id", referencedColumnName="id", nullable=true)
     */
    protected $status;
    
    /**
     * @var String @Column(name="assunto", type="string", length=255)
     */
    protected $subject;
    
    /**
     * @var @Column(name="conteudo", type="text", length=65532)
     */
    protected $content;

    /**
     * @var Boolean @Column(name="rascunho", type="boolean", options={ "default": true })
     */
    protected $draft;
    
    /**
     * @var Boolean @Column(name="arquivado", type="boolean", options={ "default": false })
     */
    protected $archived;
    
    /**
     * @var Boolean @Column(name="assinado", type="boolean", options={ "default": false })
     */
    protected $signed;

    /**
     * @var Datetime @Column(name="data_criacao", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $createdAt;

    public function __construct() {
        $this->id = 0;
        $this->user = '';
        $this->type = '';
        $this->status = null;
        $this->signatureList = new ArrayCollection();
        $this->draft = true;
        $this->archived = false;
        $this->signed = false;
        $this->subject = null;
        $this->content = '';
        $this->createdAt = new \DateTime();
        parent::__construct();
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
        $this->user = $this->getRepositoryOf('User', $user);
        
        return $this;
    }

    public function getType() {
        return $this->type;
    }
    public function setType($type) {
        $this->type = $this->getRepositoryOf('EletronicDocumentType', $type);
        
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }
    public function setStatus($status) {
        $this->status = $this->getRepositoryOf('EletronicDocumentStatus', $status);
        
        return $this;
    }

    public function getSignatureList() {
        return $this->signatureList;
    }
    public function addSignatureOnList($signature) {
        $this->signatureList->add($signature);

        return $this;
    }
    public function removeSignatureOnList($signature) {
        $this->signatureList->removeElement($signature);
        
        return $this;
    }
    public function setSignatureList($signatureList) {
        $this->signatureList = new ArrayCollection($signatureList);

        return $this;
    }
    
    public function setGroupList($signatureList) {
        // $this->signatureList = new ArrayCollection($signatureList);

        return $this;
    }

    public function getDraft() {
        return $this->draft;
    }
    public function isDraft() {
        return $this->getDraft();
    }
    public function setDraft($draft) {
        $this->draft = $draft ? true : false;
        
        return $this;
    }
    
    public function getArchived() {
        return $this->archived;
    }
    public function isArchived() {
        return $this->getArchived();
    }
    public function setArchived($archived) {
        $this->archived = $archived ? true : false;
        
        return $this;
    }

    public function getSigned() {
        return $this->signed;
    }
    public function isSigned() {
        return $this->getSigned();
    }
    public function setSigned($signed) {
        $this->signed = $signed ? true : false;
        
        return $this;
    }

    public function getSubject() {
        return $this->subject;
    }
    public function setSubject($subject) {
        $this->subject = $subject;
        
        return $this;
    }
   
    public function getContent() {
        return $this->content;
    }
    public function setContent($content) {
        $this->content = $content;
        
        return $this;
    }

    public function getCreatedDate() {
        return $this->createdDate;
    }
    public function setCreatedDate($createdDate) {
        $this->createdDate = $this->_formatDate($createdDate);
        
        return $this;
    }

}