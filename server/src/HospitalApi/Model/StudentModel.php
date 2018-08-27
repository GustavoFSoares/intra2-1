<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\User;
use HospitalApi\Entity\UserComplement;

/**
* <b>StudentModel</b>
 */
class StudentModel extends SoftdeleteModel
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
        $Student = $this->find($id);
        if($Student) {
            return $Student[0];
        } else {
            return null;
        }
    }

    public function find($id = null) {
        $query = $this->em->createQueryBuilder();
        $query->select('u')
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

}