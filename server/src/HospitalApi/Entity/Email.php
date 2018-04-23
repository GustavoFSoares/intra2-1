<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="email")
 * <b>Email</b>
 * Classe POJO responsável por manter os atributos de um email,
 * como também fazer as relações e mapeamento com banco de dados
 */
class Email extends EntityAbstract
{
    /**
     * @var integer @Id
     *      @Column(name="id", type="integer")
     *      @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var DateTime
     *      @Column(name="horario", type="string")
     */
    protected $time;

    /**
     * @var String
     *      @Column(name="remetente", type="string", length=255)
     */
    protected $sender;

    /**
     * @var String
     *      @Column(name="destinatario", type="string", length=255)
     */
    protected $receiver;

    /**
     * @var Text
     *      @Column(name="corpo", type="text")
     */
    protected $body;

    public function __construct($sender = "", $receiver = "", $body = "") {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->body = $body;
        $this->time = date('Y-m-d H:i');
    }

    public function getId() {
        return $this->id;
    }

    public function getSender() {
        return $this->sender;
    }
    public function setSender($sender) {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver() {
        return $this->receiver;
    }
    public function setReceiver($receiver) {
        $this->receiver = $receiver;

        return $this;
    }

    public function getBody() {
        return $this->body;
    }
    public function setBody($body) {
        $this->body = $body;

        return $this;
    }

    public function getTime() {
        return $this->time;
    }

}