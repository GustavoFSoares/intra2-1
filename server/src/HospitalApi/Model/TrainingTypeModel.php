<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\TrainingType;
/**
 * <b>TrainingTypelModel</b>
 */
class TrainingTypeModel extends ModelAbstract
{

    public $entity;

    public function __construct() {
        $this->entity = new TrainingType;
        parent::__construct();
    }

}
