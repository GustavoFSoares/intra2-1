<?php
namespace HospitalApi\Model;

abstract class SoftdeleteModel extends ModelAbstract
{

    public function findAll() {
        $collection = $this->em->getRepository($this->entityPath)->findBy(['c_removed' => 0]);
        
        return $collection;
    }
}
