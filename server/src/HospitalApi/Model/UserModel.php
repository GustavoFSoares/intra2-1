<?php

namespace HospitalApi\Model;
use HospitalApi\Entity\User;

/**
 * <b>UserModel</b>
 */
class UserModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new User;
        parent::__construct();
    }

    public function findById($id, $showRemoved = false) {
        $User = parent::findById($id, $showRemoved);
        if($User) {
            $group = $User->getGroup();
            $complement = $User->getComplement();
            
            $User->setGroup($group->toArray());
            if($complement){
                $User->setComplement($complement->toArray());
            }
        }
        return $User;
    }

    public function findBy($filters) {
        $select = $this->em->createQueryBuilder()
            ->select('u')
            ->from('HospitalApi\Entity\User', 'u')
            ->where('u.c_removed = 0');

        if( isset($filters['name']) ) {
            $select
                ->where('u.name LIKE :name')
                ->setParameter('name', "%{$filters['name']}%");
            unset($filters['name']);
        }

        foreach ($filters as $filter => $value) {
            $select
                ->andWhere("u.$filter = :$filter")
                ->setParameter($filter, $value);
        }
        $Users = $select->getQuery()->getResult();
        
        $users = [];
        if($Users) {
            foreach ($Users as $User) {
                $group = $User->getGroup();
                $complement = $User->getComplement();
                
                $User->setGroup($group->toArray());
                if($complement){
                    $User->setComplement($complement->toArray());
                }
                $users[] = $User;
            }
        }
        return $users;
    }

    public function getUsersAdminWithEmail($group = null) {
        $select = $this->em->createQueryBuilder();
        $select
            ->select('u')
            ->from($this->getEntityPath(), 'u')
            ->where('u.admin = 1')
            ->andWhere('u.c_removed = 0')
            ->andWhere('u.email != :null')
            ->setParameter('null', "");
        if($group) {
            $select
                ->andWhere('u.group = :group')
                ->setParameter('group', $group);
        }
        $Users = $select->getQuery()->getResult();
        $users = [];
        if($Users) {
            foreach ($Users as $User) {
                $group = $User->getGroup();
                $complement = $User->getComplement();
                
                $User->setGroup($group->toArray());
                if($complement){
                    $User->setComplement($complement->toArray());
                }
                $users[] = $User;
            }
        }
        return $users;
    }

    public function mount($values) {
        $group = $this->em->getRepository('HospitalApi\Entity\Group')->find($values['group']['id']);
        $values['group'] = $group;

        return $values;
    }

    public function findUsersByNameOrCode($name = "", $code = "") {
        $select = $this->em->createQueryBuilder();
        $select
            ->select('u')
            ->from($this->getEntityPath(), 'u');
        if($name && is_string($name) ) {
            $select->OrWhere('u.name LIKE :name')->setParameter('name', "%".strtolower($name)."%" );
        }

        if($code && is_numeric($code) ) {
            $select->OrWhere("u.code LIKE :code")->setParameter('code', "%$code%" );
        }
        $select->andWhere('u.c_removed = 0');
        
        $Users = $select->getQuery()->getResult();
        $users = [];
        if($Users) {
            foreach ($Users as $User) {
                $group = $User->getGroup();
                $complement = $User->getComplement();
                
                $User->setGroup($group->toArray());
                if($complement){
                    $User->setComplement($complement->toArray());
                }
                $users[] = $User;
            }
        }
        return $users;
    }

    public function mergeUsers($userId1, $userId2) {
        $user1 = $this->getRepository()->find( $userId1 );
        $user2 = $this->getRepository()->find( $userId2 );

        $user1
            ->setName( $user2->getName() )
            ->setCode( $user2->getCode() )
            ->setOccupation( $user2->getOccupation() );
    
        try {
            $this->doUpdate($user1);
            $this->doDelete($user2);
            
            return true;
        } catch(\Exception $e) {
            return false;
        }

    }
}
