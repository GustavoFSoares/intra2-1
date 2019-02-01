<?php
namespace HospitalApi\Entity;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity
 * @\Doctrine\ORM\Mapping\HasLifecycleCallbacks
 * @Table(name="Documento_Eletronico_Emenda")
 * <b>EletronicDocumentAmendment</b>
 */
class EletronicDocumentAmendment extends EntityAbstract
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
     * @ManyToMany(targetEntity="EletronicDocumentSignature")
     * @JoinTable(name="documento_eletronico_emenda_documento_eletronico_assinatura",
     *      joinColumns={@JoinColumn(name="emenda_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@JoinColumn(name="assinatura_id", referencedColumnName="id")}
     *      )
     */
    protected $signatureList;
    
    /**
     * @var String @Column(name="titulo", type="string")
     */
    protected $title;
    
    /**
     * @var @Column(name="conteudo", type="text", length=65532)
     */
    protected $text;

    /**
     * @ManyToOne(targetEntity="EletronicDocument", inversedBy="amendmentList", cascade={"persist", "remove"})
     * @JoinColumn(name="documento_id", referencedColumnName="id")
     */
    private $_document;

    public function __construct($id = 0) {
        parent::__construct();
        $this->id = $id;
        $this->user = null;
        $this->signatureList = new ArrayCollection();
        $this->title = '';
        $this->text = '';
        $this->_document = null;
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
        $this->signatureList = $this->buildList($this->getSignatureList(), $signatureList);

        return $this;
    }
    public function clearSignatureList() {
        $this->signatureList->clear();

        return $this;
    }
    
    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title =  $title;
        
        return $this;
    }
    
    public function getText() {
        return $this->text;
    }
    public function setText($text) {
        $this->text =  $text;
        
        return $this;
    }
    
    public function getDocument() {
        return $this->_document;
    }
    public function setDocument($document) {
        $this->_document = $this->getRepositoryOf('EletronicDocument', $document);
        
        return $this;
    }

}