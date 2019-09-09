<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Cardapio;
use DateTime;
/**
 * <b>CardapioModel</b>
 */
class CardapioModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Cardapio;
        parent::__construct();
    }

    public function mount($values) {
        $values = (object)$values;
        if ( isset($value->id) ) {
            $this->entity = $this->getRepository()->find($values->id);
        }

        return $values;
    }

    public function getNextMeal() {

        $query = $this->em->createQueryBuilder();
        $query->select('c')
            ->from('HospitalApi\Entity\Cardapio', 'c')
            ->where('c.data = :today')
            ->setMaxResults('2')
            ->setParameter('today', date("Y-m-d", time()));
        return $query->getQuery()->getResult();
    }

    public function getCardapios() {
        $select = $this->em->createQueryBuilder();
        $select->select('c')
            ->from($this->getEntityPath(), 'c')
            ->orderBy('c.data', 'ASC');
        return $select->getQuery()->getResult();

    }

    public function findById($id) {
        $select = $this->em->createQueryBuilder();
        $select->select('c')
            ->from($this->getEntityPath(), 'c')
            ->where('c.id = :id')
            ->setParameter('id', $id);
        return $select->getQuery()->getOneOrNullResult();
    }
}