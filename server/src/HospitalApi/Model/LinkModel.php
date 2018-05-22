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

    public function findAll() {
        $collection = $this->getRepository()->findBy(
            ['c_removed' => 0], 
            ['title' => 'ASC']
        );

        return $collection;
    }
}
