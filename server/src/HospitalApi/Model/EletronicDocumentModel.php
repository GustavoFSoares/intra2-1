<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\EletronicDocument;

/**
 * <b>EletronicDocumentModel</b>
 */
class EletronicDocumentModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new EletronicDocument;
        parent::__construct();
    }

}
