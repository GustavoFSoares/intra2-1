<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\Enterprise;

/**
 * <b>EnterpriseModel</b>
 */
class EnterpriseModel extends SoftdeleteModel
{

    public $entity;

    public function __construct()
    {

        $this->entity = new Enterprise();
        parent::__construct();
    }

}