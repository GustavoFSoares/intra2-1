<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\EletronicDocumentType;

/**
 * <b>EletronicDocumentTypeModel</b>
 */
class EletronicDocumentTypeModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new EletronicDocumentType;
        parent::__construct();
    }

}
