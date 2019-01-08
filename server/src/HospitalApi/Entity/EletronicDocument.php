<?php
namespace HospitalApi\Entity;
use DateTime;

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
     * @var String @Column(name="assunto", type="string", length=255)
     */
    protected $subject;

    /**
     * @ManyToOne(targetEntity="EletronicDocumentType")
     * @JoinColumn(name="tipo_id", referencedColumnName="id")
     */
    protected $type;

    /**
     * @OneToOne(targetEntity="EletronicDocumentOriginDestination", mappedBy="eletronicDocument", cascade={"persist", "remove"})
     */
    protected $originDestination;

    /**
     * @ManyToOne(targetEntity="EletronicDocumentStatus")
     * @JoinColumn(name="status_id", referencedColumnName="id")
     */
    protected $status;
    
    /**
     * @var Boolean @Column(name="rascunho", type="boolean", options: { default: false })
     */
    protected $draft;

    /**
     * @var Datetime @Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $createdDate;

    public function __contruct() {
        parent::__construct();
        $this->id = 0;
        $this->subject = null;
        $this->type = '';
        $this->status = '';
        $this->draft = null;
        $this->createdDate = new DateTime();
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        
        return $this;
    }
    
    public function getsubject() {
        return $this->subject;
    }
    public function setsubject($subject) {
        $this->subject = $subject;
        
        return $this;
    }

    public function gettype() {
        return $this->type;
    }
    public function settype($type) {
        $this->type = $type;
        
        return $this;
    }

    public function getstatus() {
        return $this->status;
    }
    public function setstatus($status) {
        $this->status = $status;
        
        return $this;
    }

    public function getdraft() {
        return $this->draft;
    }
    public function setdraft($draft) {
        $this->draft = $draft;
        
        return $this;
    }

    public function getcreatedDate() {
        return $this->createdDate;
    }
    public function setcreatedDate($createdDate) {
        $this->createdDate = $this->_formatDate($createdDate);
        
        return $this;
    }

}