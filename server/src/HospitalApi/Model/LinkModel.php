<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Link;

/**
 * <b>LinkModel</b>
 */
class LinkModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Link;
        parent::__construct();
    }

    public function findBy($filters = []) {
        return parent::findBy($filters, ['title' => 'ASC']);
    }
}
