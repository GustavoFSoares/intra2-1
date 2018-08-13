<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Mensagem_Status")
 * <b>StatusMessage</b>
 * Classe contendo o objeto das StatusMessage's cadastradas
 */
class StatusMessage extends EntityAbstract
{

    /**
     * @var integer @Id
     *     @Column(name="id", type="string")
     */
    protected $id;

    /**
     * @var string @Column(name="status", type="boolean")
     */
    protected $status;

    /**
     * @var string @Column(name="ds_status", type="string", length=255)
     */
    protected $message;
    
    /**
     * @var string @Column(name="tipo", type="string", length=255)
     */
    protected $type;
    
    public function __construct($id = '', $status = '', $message = '', $type = '') {
        $this->id = $id;
        $this->status = $status;
        $this->message = $message;
        $this->message = $type;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getStatus() {
        return $this->status;
    }
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    public function getMessage() {
        return $this->message;
    }
    public function setMessage($message) {
        $this->message = $message;

        return $this;
    }
    
    public function getType() {
        return $this->type;
    }
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

}