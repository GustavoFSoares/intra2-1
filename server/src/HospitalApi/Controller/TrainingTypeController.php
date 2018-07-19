<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\TrainingTypeModel;

/**
 * <b>TrainingTypeController</b>
 */
class TrainingTypeController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new TrainingTypeModel());
    }

}