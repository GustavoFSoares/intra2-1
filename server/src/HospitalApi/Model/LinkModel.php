<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Link;

/**
 * <b>LinkModel</b>
 */
class LinkModel extends SoftdeleteModel
{

    public $entity;
    protected $_ORDERS = [ 'title' => 'ASC' ];

    public function __construct() {
        $this->entity = new Link;
        parent::__construct();
    }

    public function findBy($filters = [], $orders = []) {
        return parent::findBy($filters, $orders);
    }

    public function changeStatus($id) {
        $this->entity = $this->getRepository()->find($id);
        $this->entity->setActive( !$this->entity->isActive() );

        $this->doUpdate( $this->entity );

        return true;
    }
}
