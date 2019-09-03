<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Cardapio;
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
            ->setParameter('today', '2019-09-02 00:00:00');
        return $query->getQuery()->getResult();
    }
}