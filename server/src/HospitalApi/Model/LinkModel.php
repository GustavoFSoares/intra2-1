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
        $collection = $this->em->getRepository($this->entityPath)->findBy([ ], ['title' => 'ASC']);

        return $collection;
    }
}
