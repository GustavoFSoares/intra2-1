<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\UserType;

/**
 * <b>UserTypeModel</b>
 */
class UserTypeModel extends SoftdeleteModel
{

    public $entity;

    public function __construct()
    {

        $this->entity = new UserType();
        parent::__construct();
    }

}