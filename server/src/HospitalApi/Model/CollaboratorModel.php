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
        $user->setLevel('1');
        $type = $this->em->getRepository('HospitalApi\Entity\UserType')->find( $user->getComplement()['type']['id']);

        $complement = new UserComplement();
        if(!$user->getId()) {
            $id = $this->getNextId($type);
            $user
                ->setId($id)
                ->setCode($id);
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

        if($complement->getId()) {
            $this->em->merge($complement);
        } else {
            $this->em->persist($complement);
        }
        
        return $user;
    }

    public function findAll() {
        return $this->find();
    }

    public function findById($id) {
        $Collaborator = $this->find($id);
        if($Collaborator) {
            return $Collaborator[0];
        } else {
            return null;
        }
    }

    public function find($id = null) {
        $query = $this->em->createQueryBuilder();
        $query
            ->select('u')
            ->from('HospitalApi\Entity\User', 'u')
            ->innerJoin('HospitalApi\Entity\UserComplement', 'uc',
                'WITH', 'u = uc.user');
        if($id) {
            $query
                ->where("u.id = :id")
                ->setParameter('id', $id);
        }
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
        $query = $this->em->createQueryBuilder();
        $query
            ->select('u')
            ->from('HospitalApi\Entity\User', 'u')
            ->innerJoin('HospitalApi\Entity\UserComplement', 'uc',
                'WITH', 'u = uc.user');
        $query
            ->where('uc.type = :type')
            ->setParameter('type', $type);
        $query->setMaxResults('1');
        $data = $query->getQuery()->getResult();
        
        if($data) {
            return $data[0];
        }
        return null;
    }

}