<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\Module;
use Doctrine\ORM\PersistentCollection;

class ModuleModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Module();
        parent::__construct();
    }

    public function findByGroup($group){
        $query = $this->em->createQueryBuilder();
        $query
            ->select('m')
            ->from('HospitalApi\Entity\Module', 'm')
            ->innerJoin('m.groups', 'g', 'WITH', 'g.groupId = :group')
            ->setParameter('group', $group)
            ->where('m.c_removed != 1');
        $collection = $query->getQuery()->getResult();

        return $collection;
    }

    public function findAll() {
        $collection = $this->getRepository()->findAll();

        return $collection;
    }

}