<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\LinkModel;

class LinkController extends ControllerAbstract
{
    public function __construct(){
        parent::__construct(new LinkModel());
    }

}