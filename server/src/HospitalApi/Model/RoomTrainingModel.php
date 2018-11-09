<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\RoomTraining;

/**
 * <b>RoomTrainingModel</b>
 */
class RoomTrainingModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new RoomTraining;
        parent::__construct();
    }

    public function mount($values) {
        $values = (object)$values;
        $groupRepository = $this->em->getRepository("HospitalApi\Entity\Group");
        
        $values->group = $groupRepository->find($values->group['id']);

        return $values;
    }

    
}
