<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Ramal;

/**
 * <b>RamalModel</b>
 */
class RamalModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Ramal;
        parent::__construct();
    }

    public function mount($values) {
        $values = (object)$values;
        $groupRepository = $this->em->getRepository("HospitalApi\Entity\Group");
        
        $values->group = $groupRepository->find($values->group['id']);

        return $values;
    }

    public function findAll() {
        $collection = $this->getRepository()->findBy([], ['group' => 'ASC', 'core' => 'ASC']);

        return $collection;
    }
}
