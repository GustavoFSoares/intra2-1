<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Training;
/**
 * <b>TraininglModel</b>
 */
class TrainingModel extends ModelAbstract
{

    public $entity;
    public $inverseOrder = true;

    public function __construct() {
        $this->entity = new Training;
        parent::__construct();
    }

    public function mount($values) {
        $values = (object)$values;
        if( isset($values->id) ) {
            $this->entity = $this->getRepository()->find($values->id);
        }

        $userRepository = $this->em->getRepository('HospitalApi\Entity\User');

        $values->place['enterprise'] = is_array($values->place['group']) ? $values->place['group']['enterprise'] : null;
        $values->place['room'] = array_key_exists('id', $values->place['room']) ? $values->place['room']['id'] : null;
        $values->institutionalType = ( isset($values->type['id']) && $values->type['id'] == 'institutional') ? $values->institutionalType['name'] : null;
        $values->type = is_array($values->type) ? $values->type['name'] : $values->type;
        
        $instructors = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($values->instructors as $instructor) {
            if( isset($instructor['canRemove']) ) {
                $instructor = $userRepository->find($instructor['id']);
                if( isset($values->id) ) {
                    $this->entity->addInstructor($instructor);
                    $this->doUpdate($this->entity);
                } else {
                    $instructors->add($instructor);
                }
            }
        }
        $values->instructors = $instructors;
        
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
