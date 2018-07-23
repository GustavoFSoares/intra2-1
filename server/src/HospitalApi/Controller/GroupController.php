<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\GroupModel;

class GroupController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new GroupModel());
    }

    public function getEnterprises($req, $res, $args) {
        $data = $this->getModel()->findEnterprises();
        return $res->withJson($data);
    }   

}