<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\DuplicatedUsers;

/**
* <b>DuplicatedUsersModel</b>
 */
class DuplicatedUsersModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new DuplicatedUsers();
        parent::__construct();
    }

}