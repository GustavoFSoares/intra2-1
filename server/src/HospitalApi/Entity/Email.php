<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="email")
 */
class Email extends EntityAbstract
{
    /**
     * @var integer @Id
     *      @Column(name="id", type="integer")
     *      @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var DateTime
     *      @Column(type="datetime")
     */
    private $time;

    /**
     * @var String
     *      @Column(type="string")
     */
    private $sender;

    /**
     * @var String
     *      @Column(type="string")
     */
    private $receiver;

    /**
     * @var Text
     *      @Column(type="text")
     */
    private $body;

    public function __construct($sender = "", $receiver = "", $body = ""){
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->body = $body;
        $this->time = date('Y-m-d H:i');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSender(){
        return $this->sender;
    }
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(){
        return $this->receiver;
    }
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getBody(){
        return $this->body;
    }
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function getTime(){
        return $this->time;
    }

}