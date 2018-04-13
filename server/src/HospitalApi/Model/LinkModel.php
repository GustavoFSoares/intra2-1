<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Link;

class LinkModel extends ModelAbstract
{

    public $entity;

    public function __construct() {
        $this->entity = new Link;
        parent::__construct();
    }
}
