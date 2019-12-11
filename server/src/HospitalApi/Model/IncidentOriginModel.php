<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\IncidentOrigin;
use Doctrine\DBAL\Event\SchemaAlterTableAddColumnEventArgs;

class IncidentOriginModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new IncidentOrigin();
        parent::__construct();
    }

    public function findByOriginId($originId){
        return $this->getRepository()->findOneBy(['OriginId' => $originId, 'c_removed' => 0]);
    }

    public function findEnterprises() {
        $query = $this->em->createQueryBuilder();
        $query
            ->select('oi.enterprise')
            ->from($this->entityPath, 'oi')
            ->where('oi.c_removed = 0')
            ->distinct('oi.enterprise');
        $collection = $query->getQuery()->getResult();
        
        return $collection;
    }

}