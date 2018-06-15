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

        if(!$this->ADAllowed()){
            $user = [
                'id' => USERTEST_ID,
                'name' => USERTEST_NAME,
                'group' => USERTEST_GROUP,
                'ocupation' => USERTEST_OCUPATION
            ];
            return $res->withJson($user);
        }

        $Ad = new ActiveDirectoryController();
        if ($Ad->doAuth($user)) {
            $this->doLogin($user->id);
        } else {
            die('nao deu');
        }

    }

    public function doLogin($id) {
        
        $model = $this->getModel();
        $User = $model->findById($id);
        
        if(!$User) {
            $User = $Ad->getUserContents($id);
            $User = [
                'id' => $user[0]['samaccountname'][0],
                'name' => $user[0]['displayname'][0],
                'group' => $user[0]['department'][0],
                'ocupation' => $user[0]['description'][0],
            ];
        }


    }

}