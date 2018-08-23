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
        $values->institutionalType = ($values->type['id'] == 'institutional') ? $values->institutionalType['name'] : null;
        $values->type = is_array($values->type) ? $values->type['name'] : $values->type;
        $values->instructor = $this->em->getRepository("HospitalApi\Entity\User")->findOneById($values->instructor['id']);

        return $values;
    }

    public function isDone($id) {
        $repository = $this->getRepository()->find($id);
        $repository->setDone(true);

        $this->doUpdate($repository);

        return true;
    }

    public function getUnrealized(){
        $query = $this->em->createQueryBuilder();
        $query->select('t')
            ->from('HospitalApi\Entity\Training', 't')
            ->where('t.beginTime > :now')
            ->andWhere('t.done = 0')
            ->orderBy('t.beginTime')
            ->setParameter('now', new \DateTime());
        return $query->getQuery()->getResult();
    }

    public function doDelete($obj) {
        $obj->setInstructor(null);
        
        return parent::doDelete($obj);
    }

}
