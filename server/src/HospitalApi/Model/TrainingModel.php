<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Training;
/**
 * <b>TraininglModel</b>
 */
class TrainingModel extends ModelAbstract
{

    public $entity;

    public function __construct() {
        $this->entity = new Training;
        parent::__construct();
    }

    public function mount($values) {
        $values = (object)$values;

        $values->place = is_array($values->place) ? $values->place['enterprise'] : $values->place;
        $values->type = is_array($values->type) ? $values->type['name'] : $values->type;
        $values->institutionalType = ($values->type['id'] == 'institutional') ? $values->institutionalType['name'] : null;
        $values->instructor = $this->em->getRepository("HospitalApi\Entity\User")->findOneById($values->instructor['id']);

        return $values;
    }

    public function isDone($id) {
        $repository = $this->getRepository()->find($id);
        $repository->setDone(true);

        $this->doUpdate($repository);

        return true;
    }

    public function doDelete($obj) {
        $obj->setInstructor(null);
        
        return parent::doDelete($obj);
    }

}
