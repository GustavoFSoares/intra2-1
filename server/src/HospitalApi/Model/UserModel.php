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
        if($User){
            $group = $User->getGroup()->toArray();
            $User->setGroup($group);
        }
        return $User;
    }
}
