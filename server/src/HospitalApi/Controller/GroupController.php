<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\GroupModel;

class GroupController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new GroupModel());
    }

}