<?php
namespace HospitalApi\Template;

use HospitalApi\BasicApplicationAbstract;

abstract class EmailTemplateAbstract extends BasicApplicationAbstract implements EmailTemplateInterface
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
    public function setReceiver($receiver) {
        if($this->isDebug()) {
            return $this->getDebugEmail();
        } else {
            return $receiver;
        }    
    }
    

    public function getSubject() {
        return $this->subject;
    }

    public function getBody() {
        return $this->body;
    }

}