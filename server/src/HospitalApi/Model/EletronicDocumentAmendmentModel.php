<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\EletronicDocumentAmendment;
/**
 * <b>EletronicDocumentAmendmentModel</b>
 */
class EletronicDocumentAmendmentModel extends ModelAbstract
{

    public $entity;
    public $inverseOrder = true;

    public function __construct() {
        $this->entity = new EletronicDocumentAmendment;
        parent::__construct();
    }

    public function mount($values) {  
        return $values;
    }

}
