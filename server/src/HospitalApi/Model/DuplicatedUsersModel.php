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
        $positiveResponse = [
            'users' => "<b>{$this->entity->getUser1()->getId()}</b> - <b>{$this->entity->getUser2()->getId()}</b>",
            'message' => "Cadastro Unificado",
            'status' => 'success',
        ];
        $negativeResponse = [
            'users' => "<b>{$this->entity->getUser1()->getId()}</b>-<b>{$this->entity->getUser2()->getId()}</b>",
            'message' => "Problema ao Unir",
            'status' => 'danger',
        ];

        if($this->entity) {
            $userRepository = $this->em->getRepository('HospitalApi\Entity\User');
            
            $UserModel = new \HospitalApi\Model\UserModel();
            $merged = $UserModel->mergeUsers( $this->entity->getUser1()->getId(), $this->entity->getUser2()->getId() );
            
            if($merged) {
                $this->doDelete($this->entity);
                $response = $positiveResponse;
            } else {
                $response = $negativeResponse;
            }
        } else {
           $response = $negativeResponse;
        }

        return $response;
    }

}