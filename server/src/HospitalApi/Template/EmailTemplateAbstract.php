<?php
namespace HospitalApi\Template;

use HospitalApi\BasicApplicationAbstract;

abstract class EmailTemplateAbstract extends BasicApplicationAbstract implements EmailTemplateInterface
{

    protected $sender;
    protected $receiver;
    protected $copy;
    protected $subject;
    protected $body;
    
    public function getTemplate() {
        return $this;
    }

    public function getSender() {
        return $this->sender;
    }
    public function setSender($sender) {
        if($sender) {
            $this->sender = $sender;
        } else {
            $this->sender = $this->getEmailDefault();
        }

        return $this;
    }

    public function getReceiver() {
        return $this->receiver;
    }
    public function setReceiver($receiver) {
        if($this->isDebug()) {
            $this->receiver = $this->getDebugEmail();
        } else {
            $this->receiver = $receiver;
        }

        return $this;
    }

    public function getCopy() {
        return $this->copy;
    }
    public function setCopy($copy) {
        if(!$this->isDebug()) {
            $this->copy = [$this->getDebugEmail()];
        } else {
            foreach ($copy as $c) {
                $this->copy[] = $c;
            }
        }

        return $this;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getBody() {
        return $this->body;
    }

}