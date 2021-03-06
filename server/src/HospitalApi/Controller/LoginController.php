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
                    ->setGroup($this->getRepositoryGroupById(USERTEST_GROUP)->toArray())
                    ->setOccupation(USERTEST_OCCUPATION);
                $result = ['status' => true, 'user' => $User->toArray() ];
            } else {
                $model = new \HospitalApi\Model\StatusMessageModel();
                $result = $model->getStatus('user_incorrect')->toArray();
            }
            return $res->withJson($result);
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
        $User = $model->findById($id, true);
        $Ad = new ActiveDirectoryController();
        
        if(!$User) {
            $adValues = $Ad->getUserContents($id);
            
            $user = [
                'id' => $adValues[0]['samaccountname'][0],
                'name' => $adValues[0]['displayname'][0],
                'group' => $Ad->getGroupArray(isset($adValues[0]['department']) ? $adValues[0]['department'][0] : '' ),
                'occupation' => $adValues[0]['description'][0]?$adValues[0]['description'][0]:'',
                'code' => $adValues[0]['physicaldeliveryofficename'][0]?$adValues[0]['physicaldeliveryofficename'][0]:'0',
            ];
            $group = $this->getRepositoryGroupById($user['group']['name']);

            if(!$group){
                $StatusMessageModel = new \HospitalApi\Model\StatusMessageModel();
                return $model->getStatus('group_not_found')->toArray();
            }

            $User = new User();
            $User
                ->setId($user['id'])
                ->setCode($user['code'])
                ->setName($user['name'])
                ->setGroup($group)
                ->setOccupation($user['occupation'])
                ->setNewLogin();
            $model->doInsert($User);
            $User = $model->findById($id);
        }
        
        $StatusMessageModel = new \HospitalApi\Model\StatusMessageModel();
        if($User->isRemoved() || !$Ad->isActive($id)){
            return $StatusMessageModel->getStatus('user_removed')->toArray();
        } else if(!$User->isActive()) {
            return $StatusMessageModel->getStatus('user_inactive')->toArray();
        }
        
        $response = [ 'status' => true, 'user' => $User->toArray() ];
        
        $this->setNewLogin($User);

        return $response;
    }

    public function getRepositoryGroupById($id) {
        $groupRepository = $this->getModel()->em->getRepository('HospitalApi\Entity\Group');
        $group = $groupRepository->findOneByGroupId(\Helper\SlugHelper::get($id));
        
        return $group;
    }

    public function setNewLogin($user) {
        $model = $this->getModel();
        $group = $this->getRepositoryGroupById($user->getGroup()['groupId']);
        
        $user = $model->getRepository()->find($user->getId());
        $user
            ->setGroup($group)
            ->setNewLogin();

        $model->doUpdate($user);
    }

}