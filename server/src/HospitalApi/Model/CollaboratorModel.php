<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\User;
use HospitalApi\Entity\UserComplement;

/**
* <b>CollaboratorModel</b>
 */
class CollaboratorModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new User();

        ModelAbstract::__construct();
    }

    public function mount($user) {
        $type = $this->em->getRepository('HospitalApi\Entity\UserType')->find( $user->getComplement()['type']['id']);

        if(!$user->getId()) {
            $complement = new UserComplement();
            $id = $this->getNextId($type);
            $user
                ->setId($id)
                ->setCode($id)
                ->setActive(true);
        } else {
            $complement = $this->em->getRepository('HospitalApi\Entity\UserComplement')->find( $user->getComplement()['id']);
        }

        foreach ($user->getComplement() as $key => $value) {
			$method = "set$key";
			$complement->$method($value);
        }
        
        $complement
            ->setType($type)
            ->setUser($user);

        $user
            ->setGroup($this->em->getRepository('HospitalApi\Entity\Group')->find( $user->getGroup()['id'] ))
            ->setComplement($complement);

        return $user;
    }

    public function findBy($id = null) {
        $query = $this->em->createQueryBuilder();
        $query
            ->select('u')
            ->from('HospitalApi\Entity\User', 'u')
            ->innerJoin('HospitalApi\Entity\UserComplement', 'uc',
                'WITH', 'u = uc.user')
            ->orderBy('uc.type')
            ->orderBy('u.c_created')
            ->where('u.c_removed = 0');
        
        return $query->getQuery()->getResult();
    }

    public function getNextId($type) {
        $lastCollaborator = $this->getLastUserCollaboratorByType($type);

        if($lastCollaborator) {
            $id = $lastCollaborator->getId();
            $prefix = substr($id, 0, 1);
            $sufix = substr($id, 1);

            $id = $prefix.($sufix+1);
        } else {
            $name = $type->getName();
            $prefix = substr($name, 0, 1);
            
            $id = $prefix."1";
        }
        return $id;
    }

    public function getLastUserCollaboratorByType($type) {
        $select = $this->em->createQueryBuilder();
        $select
            ->select('u')
            ->from('HospitalApi\Entity\User', 'u')
            ->innerJoin('HospitalApi\Entity\UserComplement', 'uc',
                'WITH', 'u = uc.user');
        $select
            ->where('uc.type = :type')
            ->setParameter('type', $type)
            ->orderBy('u.c_created', 'desc')
            ->setMaxResults('1');
        $data = $select->getQuery()->getOneOrNullResult();
        
        return $data;
    }

}