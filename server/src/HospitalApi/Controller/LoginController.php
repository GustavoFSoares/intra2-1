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
            if($user->id == USERTEST_ID || $user->password == USERTEST_PWD){
                $User = new User();
                $User 
                    ->setId(USERTEST_ID)
                    ->setName(USERTEST_NAME)
                    ->setLevel(USERTEST_LEVEL)
                    ->setGroup(USERTEST_GROUP)
                    ->setOccupation(USERTEST_OCCUPATION);
                $result = ['status' => true, 'user' => $User->toArray() ];
            } else {
                $model = new \HospitalApi\Model\StatusMessageModel();
                $result = $model->getStatus('user_incorrect')->toArray();
            }
        }

        $Ad = new ActiveDirectoryController();
        if ($Ad->doAuth($user)) {
            $result = $this->doLogin($user->id);
        } else {
            $model = new \HospitalApi\Model\StatusMessageModel();
            $result = $model->getStatus('user_incorrect')->toArray();
        }
        
        return $res->withJson($result);
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
                'occupation' => $adValues[0]['description'][0]?$adValues[0]['description'][0]:'',
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
            return $model->getStatus('user_inactive')->toArray();
        }
        
        return [ 'status' => true, 'user' => $User->toArray() ];
    }

}