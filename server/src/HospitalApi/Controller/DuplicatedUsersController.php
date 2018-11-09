<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\DuplicatedUsersModel;

class DuplicatedUsersController extends ControllerAbstractLongEntity
{
    public function __construct() {
        parent::__construct(new DuplicatedUsersModel());
    }

    public function checkDuplicationAction($req, $res, $args) {
        $duplicationId = $req->getAttribute('id');

        $return = $this->getModel()->makeMergeUsers($duplicationId);
        return $res->withJson($return);
    }

}