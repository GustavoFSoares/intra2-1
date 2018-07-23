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
        $repository = $this->getRepository()->find($values->id ? $values->id : '');

        $id = $values->id;
        $name = $values->name;
        $place = is_array($values->place) ? $values->place['enterprise'] : $values->place;
        $type = is_array($values->type) ? $values->type['name'] : $values->type;
        $institutionalType = ($values->type['id'] == 'institutional') ? $values->institutionalType['name'] : null;
        $instructor = $userRepository->findOneById($values->instructor['id']);
        $timeTraining = $values->timeTraining;
        $workload = $values->workload;
        
        foreach ($this->entity->getClassVars() as $key => $var) {
            if($key != 'users') {
                $method = "set$key";
                $this->entity->$method($$key);
            }
        }

        foreach ($values->users as $user) {
            $reUser = $userRepository->findOneById($user['id']);
            if($id) {
                if(!isset($user['loaded'])){
                    $repository->addUser($reUser);
                    $this->doInsert($repository);
                }
            } else {
                $this->entity->addUser($reUser);
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
