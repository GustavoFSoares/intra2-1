<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\Enterprise;

class EnterpriseModel extends SoftdeleteModel
{

    public $entity;

    public function __construct()
    {

        $this->entity = new Enterprise();
        parent::__construct();
    }

}