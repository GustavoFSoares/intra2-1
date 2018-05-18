<?php
namespace HospitalApi\Template;

abstract class EmailTemplateAbstract implements EmailTemplateInterface
{

    protected $sender = [ ];
    protected $receiver = '';
    protected $subject = '';
    protected $body = '';
    
    public function getTemplate() {
        return $this;
    }

    public function getSender() {
        return $this->sender;
    }

    public function getReceiver() {
        return $this->receiver;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getBody() {
        return $this->body;
    }

}