<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\EnterpriseModel;

class EnterpriseController extends ControllerAbstract
{
    public function __construct()
    {
        parent::__construct(new EnterpriseModel());
    }

}