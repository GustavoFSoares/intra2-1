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

}
