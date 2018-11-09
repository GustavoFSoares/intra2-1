<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\RoomTrainingModel;

/**
 * <b>RoomTrainingController</b>
 */
class RoomTrainingController extends ControllerAbstractLongEntity
{
    public function __construct() {
        parent::__construct(new RoomTrainingModel());
    }

}