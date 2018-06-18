<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\UserModel;
use HospitalApi\Entity\User;


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
                'level' => USERTEST_LEVEL,
                'group' => USERTEST_GROUP,
                'occupation' => USERTEST_OCCUPATION
            ];
            return $res->withJson($user);
        }

        $Ad = new ActiveDirectoryController();
        if ($Ad->doAuth($user)) {
            $result = $this->doLogin($user->id);
        } else {
            $model = new \HospitalApi\Model\StatusMessageModel();
            $result = $model->getStatus('user_incorrect');
        }

        return $res->withJson($result->toArray());
    }

    public function doLogin($id) {
        
        $model = $this->getModel();
        $User = $model->findById($id);
        
        if(!$User) {
            $Ad = new ActiveDirectoryController();
            $adValues = $Ad->getUserContents($id);
            
            $user = [
                'id' => $adValues[0]['samaccountname'][0],
                'name' => $adValues[0]['displayname'][0],
                'group' => $adValues[0]['department'][0],
                'occupation' => $adValues[0]['description'][0],
            ];

            $User = new User();
            $User
                ->setId($user['id'])
                ->setName($user['name'])
                ->setGroup($user['group'])
                ->setOccupation($user['occupation']);
            $model->doInsert($User);
        }

        if($User->isRemoved()){
            $model = new \HospitalApi\Model\StatusMessageModel();
            return $model->getStatus('user_inactive');
        }
        
        return $User;
    }

}