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

    public function findAll($filters) {
        $select = $this->em->createQueryBuilder();
        $select->select('r')
            ->from($this->getEntityPath(), 'r')
            ->innerJoin('r.group', 'g', 'WITH', 'r.group = g AND g.c_removed = 0');
            foreach ($filters as $filter => $value) {
            $select
            ->andWhere("r.$filter = :$filter")
            ->setParameter($filter, $value);
        }
        $select
            ->where('r.c_removed = 0')
            ->addOrderBy('r.group', 'ASC')
            ->addOrderBy('r.core', 'ASC');

        return  $select->getQuery()->getResult();
    }

    public function findBy($filters) {
        $select = $this->em->createQueryBuilder();
        $select->select('r')
            ->from($this->getEntityPath(), 'r')
            ->innerJoin('r.group', 'g', 'WITH', 'r.group = g AND g.c_removed = 0')
            ->where('r.c_removed = 0');
         foreach ($filters as $filter => $value) {
            $select
                ->andWhere("r.$filter = :$filter")
                ->setParameter($filter, $value);
        }
        $select
            ->where('r.c_removed = 0')
            ->andWhere('r.active = 1')
            ->addOrderBy('r.group', 'ASC')
            ->addOrderBy('r.core', 'ASC');

        return  $select->getQuery()->getREsult();
        
    }

    public function filterRamals($filter) {
        $query = $this->em->createQueryBuilder();
        $query->select('r')
            ->from('HospitalApi\Entity\Ramal', 'r')
            ->innerJoin('HospitalApi\Entity\Group', 'g',
                'WITH', 'g.id = r.group AND g.c_removed = 0')
            ->where('r.number like :filter')
            ->orWhere('r.core like :filter')
            ->orWhere('r.floor like :filter')
            ->orWhere('g.name like :filter')
            ->orderBy('r.group', 'asc')
            ->andWhere('r.c_removed = 0')
            ->andWhere('r.active = 1')
            ->setParameter('filter', "%$filter%");
        return $query->getQuery()->getResult();
    }
}
