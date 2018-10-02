<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\Group;
use Doctrine\DBAL\Event\SchemaAlterTableAddColumnEventArgs;

class GroupModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Group();
        parent::__construct();
    }

    public function findByGroupId($groupId){
        return $this->getRepository()->findOneBy(['GroupId' => $groupId, 'c_removed' => 0]);
    }

    public function findEnterprises() {
        $query = $this->em->createQueryBuilder();
        $query
            ->select('g.enterprise')
            ->from($this->entityPath, 'g')
            ->where('g.c_removed = 0')
            ->distinct('g.enterprise');
        $collection = $query->getQuery()->getResult();
        
        return $collection;
    }

}