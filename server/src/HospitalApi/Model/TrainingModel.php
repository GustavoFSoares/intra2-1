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
        $userRepository = $this->em->getRepository("HospitalApi\Entity\User");

        $id = $values->id;
        $name = $values->name;
        $place = $values->place['enterprise'] ? $values->place['enterprise'] : $values->place;
        $type = $values->type['name'];
        $institutionalType = ($values->type['id'] == 'institutional') ? $values->institutionalType['name'] : null;
        $instructor = $userRepository->findOneById($values->instructor['id']);
        $timeTraining = $values->timeTraining;
        $workload = $values->workload;
        
        foreach ($values->users as $user) {
            $user = $userRepository->findOneById($user['id']);
            $this->entity->addUser($user);
        }
        
        foreach ($this->entity->getClassVars() as $key => $var) {
            if($key != 'users') {
                $method = "set$key";
                $this->entity->$method($$key);
            }
        }

        return $this->entity;
    }

    public function doDelete($obj) {
        $obj->setInstructor(null);
        $obj->setUsers(null);
        
        return parent::doDelete($obj);
    }

}
