<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Ombudsman;
/**
 * <b>OmbudsmanModel</b>
 */
class OmbudsmanModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Ombudsman;
        parent::__construct();
    }

    public function getLastKeyOfOrigin($origin) {
        $data = $this->getRepository()->findOneBy(['origin'=>$origin->getId()]);
        $select = $this->em->createQueryBuilder();
        $select->select('o')
            ->from($this->entityPath, 'o')
            ->where("o.origin = :origin")
            ->setParameter('origin', $origin)
            ->orderBy('o.id', 'DESC')
            ->setMaxResults('1');
        return $select->getQuery()->getOneOrNullResult();
    }

    public function getOmbudsmansWaiting($params = []) {
        $select = $this->em->createQueryBuilder();
        $select->select([
            'o.id AS id',
            'ori.id AS origin',
        ]);
        $select
            ->from($this->entityPath, 'o')
            ->innerJoin('o.origin', 'ori', 'WITH', 'o.origin = ori')
            ->where('o.reported = 0');
        foreach ($params as $key => $value) {
            $select->andWhere("o.$key = :$key")
                ->setParameter($key, $value);
        }
        $data = $select->getQuery()->getResult();

        return $data;
    }

}
