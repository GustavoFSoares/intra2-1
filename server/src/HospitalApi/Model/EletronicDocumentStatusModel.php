<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\EletronicDocumentStatus;

/**
 * <b>EletronicDocumentStatusModel</b>
 */
class EletronicDocumentStatusModel extends SoftdeleteModel
{

    public $entity;
    public $_ORDERS = ['level' => 'ASC'];

    public function __construct() {
        $this->entity = new EletronicDocumentStatus;
        parent::__construct();
    }

}
