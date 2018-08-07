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

    public function findById($id) {
        $User = parent::findById($id);
        if($User) {
            $group = $User->getGroup()->toArray();
            $User->setGroup($group);
        }
        return $User;
    }

    public function findAll() {
        $Users = parent::findAll(['c_removed' => 0]);
        $users = [];
        if($Users) {
            foreach ($Users as $User) {
                $group = $User->getGroup()->toArray();
                $User->setGroup($group);
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
}
