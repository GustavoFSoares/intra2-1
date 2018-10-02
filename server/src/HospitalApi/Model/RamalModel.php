<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Ramal;

/**
 * <b>RamalModel</b>
 */
class RamalModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Ramal;
        parent::__construct();
    }

    public function mount($values) {
        $values = (object)$values;
        $groupRepository = $this->em->getRepository("HospitalApi\Entity\Group");
        
        $values->group = $groupRepository->find($values->group['id']);

        return $values;
    }

    public function findAll() {
        $collection = $this->getRepository()->findBy(['group.c_removed' => 0], ['group' => 'ASC', 'core' => 'ASC']);

        return $collection;
    }

    public function filterRamals($filter) {
        $query = $this->em->createQueryBuilder();
        $query->select('r')
            ->from('HospitalApi\Entity\Ramal', 'r')
            ->innerJoin('HospitalApi\Entity\Group', 'g',
                'WITH', 'g.id = r.group')
            ->where('r.number like :filter')
            ->orWhere('r.core like :filter')
            ->orWhere('r.floor like :filter')
            ->orWhere('g.name like :filter')
            ->orderBy('r.group', 'asc')
            ->andWhere('g.c_removed = 0')
            ->setParameter('filter', "%$filter%");
        return $query->getQuery()->getResult();
    }
}
