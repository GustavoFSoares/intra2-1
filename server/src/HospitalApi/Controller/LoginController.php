<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\UserModel;

/**
 * <b>LoginController</b>
 */
class LoginController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new UserModel());
    }

    public function auth($req, $res, $args){
        $user = (object)$req->getParsedBody();
        
        
    }

}