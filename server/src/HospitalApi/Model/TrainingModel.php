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

    public function mounte($values) {
        $userRepository = $this->em->getRepository("HospitalApi\Entity\User");

        $name = $this->em->getRepository("HospitalApi\Entity\TrainingType")->findOneById($values->name['id'])->getName();
        if($name == 'Outros') {
            $name = $values->anotherName;
        }
        $place = $values->place['enterprise'];
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
            if($key != 'users' && $key != 'id') {
                $method = "set$key";
                $this->entity->$method($$key);
            }
        }

        return $this->entity;
    }

    public function findAll() {
        $log = $this->getLogger();
        $collection = $this->getRepository()->findAll();
        
        return $collection;
    }

}
