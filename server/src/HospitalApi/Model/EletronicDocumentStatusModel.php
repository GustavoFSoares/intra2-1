<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\EletronicDocumentStatus;

/**
 * <b>EletronicDocumentStatusModel</b>
 */
class EletronicDocumentStatusModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new EletronicDocumentStatus;
        parent::__construct();
    }

}
