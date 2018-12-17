<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Ombudsman;
use Doctrine\ORM\QueryBuilder;
/**
 * <b>OmbudsmanModel</b>
 */
class OmbudsmanModel extends SoftdeleteModel
{

    protected $_ORDERS = [ 'registerTime' => 'DESC' ];

    public $entity;

    public function __construct() {
        $this->entity = new Ombudsman;
        parent::__construct();
    }

    public function mount($values) {
        $values = (object)$values;
        
        $values->reported = true;
        $values->status = 'registered';

        if(isset( $values->ombudsmanUser) ) {

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

        }

        switch ($values->origin['id']) {
            case 'INT':
                $values->group = null;
                break;
            
            case 'AMB':
                $values->bed = null;
                break;            
        }

        return $values;
    }

     public function findBy($filter) {
        $select = $this->em->createQueryBuilder();
        $select->select('o')
            ->from($this->getEntityPath(), 'o');

        $select = $this->showForJustWhoCanSee($select);
        
        if( $this->hadOrders() ) {
            foreach ($this->_ORDERS as $key => $value) {
                $select->addOrderBy("o.$key", $value);
            }
            foreach ($filter as $key => $value) {
                $select
                    ->andWhere("o.$key = :$key")
                    ->setParameter($key, $value);
            }
        }

        return $select->getQuery()->getResult();
    }

    public function showForJustWhoCanSee(QueryBuilder $select ) {
        switch ($this->getContainer()['session']->gotPermission('ombudsman')) {
            case 'ADMIN':
                break;
            
            default: 
                $select
                    ->where('o.manager = :user')
                    ->setParameter('user', $this->getContainer()['session']->get()->getId());
                break;
        }
       
        return $select;
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

    public function gotPermission($id) {
        $permission = $this->getContainer()['session']->gotPermission('ombudsman');
        
        // if($permission == 'USER') {
        //     $permission = 
        //         $this->managerInOmbudsman($this->getContainer()['session']->get(), $id) ? "USER" : false;
        // }
        
        return $permission;
    }

    public function managerInOmbudsman($user, $ombudsmanId) {
        
    }

    public function setResponse($values) {
        $this->entity = $this->getRepository()->find($values['id']);

        foreach ($values as $key => $value) {
			$method = "set$key";
			$this->entity
				->$method($value);
		}
        return $this->doUpdate($this->entity);
    }

    public function addManager($id, $user) {
        $this->entity = $this->getRepository()->find($id);
        $this->entity->setManager($user);
        $this->entity->setStatus('waiting-manager');

        try {
            $this->doUpdate($this->entity);
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }
    

}
