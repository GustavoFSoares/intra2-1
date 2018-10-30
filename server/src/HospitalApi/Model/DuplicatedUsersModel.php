<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\DuplicatedUsers;

/**
* <b>DuplicatedUsersModel</b>
 */
class DuplicatedUsersModel extends ModelAbstract
{

    public $entity;

    public function __construct() {
        $this->entity = new DuplicatedUsers();
        parent::__construct();
    }

    public function makeMergeUsers($duplicationId) {
        $this->entity = $this->getRepository()->find($duplicationId);
        if($this->entity) {
            $userRepository = $this->em->getRepository('HospitalApi\Entity\User');
            $user1 = $userRepository->find( $this->entity->getUser1()->getId() );
            $user2 = $userRepository->find( $this->entity->getUser2()->getId() );
    
            $user1
                ->setName( $user2->getName() )
                ->setCode( $user2->getCode() )
                ->setOccupation( $user2->getOccupation() );
    
            $this->doUpdate($user1);
            $this->doDelete($this->entity);
            $this->doDelete($user2);

            $response = [
                'users' => "<b>{$this->entity->getUser1()->getId()}</b> - <b>{$this->entity->getUser2()->getId()}</b>",
                'message' => "Cadastro Unificado",
                'status' => 'success',
            ];
        } else {
            $response = [
                'users' => "<b>{$this->entity->getUser1()->getId()}</b>-<b>{$this->entity->getUser2()->getId()}</b>",
                'message' => "Problema ao Unir",
                'status' => 'danger',
            ];
        }

        return $response;
    }

}