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

    public function mount($values) {
        $values = (object)$values;
        $values->ombudsman = $this->em->getRepository('HospitalApi\Entity\User')->find($values->ombudsman['id']);
        if(isset($values->manager) && $values->manager) {
            $values->manager = $this->em->getRepository('HospitalApi\Entity\User')->find($values->manager['id']);
        } else {
            $values->manager = null;
        }
        $values->origin = $this->em->getRepository('HospitalApi\Entity\OmbudsmanOrigin')->find($values->origin['id']);
        $values->reported = true;
        
        if( isset($values->ombudsmanUser['id']) && $values->ombudsmanUser['id'] ){
            $ombudsmanUser = $this->em->getRepository('HospitalApi\Entity\OmbudsmanUser')->find($values->ombudsmanUser['id']);
        } else {   
            if( !$ombudsmanUser = $this->em->getRepository('HospitalApi\Entity\OmbudsmanUser')->findOneByPatientName($values->ombudsmanUser['patientName']) ) {
                $ombudsmanUser = new \HospitalApi\Entity\OmbudsmanUser();
            }
        }
        $ombudsmanUser
            ->setPatientName($values->ombudsmanUser['patientName'])
            ->setBirthday($values->ombudsmanUser['birthday'])
            ->setEmail($values->ombudsmanUser['email'])
            ->setDeclarantName($values->ombudsmanUser['declarantName'])
            ->setPhoneNumber($values->ombudsmanUser['phoneNumber'])
            ->setAddress($values->ombudsmanUser['address']);
        $values->ombudsmanUser = $ombudsmanUser;

        switch ($values->origin->getId()) {
            case 'INT':
                $values->group = null;
                break;
            
            case 'AMB':
                if($values->group) {
                    $values->group = $this->em->getRepository('HospitalApi\Entity\Group')->find($values->group['id']);
                }
                $values->bed = null;
                break;
            
        }

        return $values;
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
