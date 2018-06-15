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

        $Ad = new ActiveDirectoryController();
        $user = (object)['id'=>"gustavo.soares", 'password'=>'gustavoti'];
        
        if($Ad->doAuth($user)) {
            $user = $Ad->getUserContents($user->id);
        } else {
            die('nao deu');
        }
        
        // $ocupation = $user[0]['description'][0];
        // $name = $user[0]['displayname'][0];
        // $group = $user[0]['department'][0];
        // $id = $user[0]['samaccountname'][0];
        $user = null;
        $user['ocupation'] = "Assistente de sistemas";
        $user['name'] = 'Gustavo Ferreira Soares';
        $user['group'] = 'TECNOLOGIA DA INFORMAÇÃO HU';
        $user['id'] = 'gustavo.soares';

        return $res->withJson($user);
    }



}