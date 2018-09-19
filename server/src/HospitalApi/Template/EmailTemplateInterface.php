<?php
namespace HospitalApi\Template;

interface EmailTemplateInterface {

    public function getSender();
    public function setSender($report);

    public function getReceiver();
    public function setReceiver($report);
    
    public function getCopy();
    public function setCopy($report);

    public function getSubject();
    public function setSubject($report);

    public function getBody();
    public function setBody($report);

}