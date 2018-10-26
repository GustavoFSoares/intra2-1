<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\UserModel;

/**
 * <b>UserController</b>
 */
class UserController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new UserModel());
    }

    public function getUsersByGroup($req, $res, $args) {
        $group = $args['group'];
        
        $model = $this->getModel();
        $data = $model->getRepository()->findByGroup($group);
        
        $collection = $this->translateCollection($data);
        return $res->withJson($collection);
    }

    public function getUsersAdminAction($req, $res, $args) {
        $data = $this->getModel()->getUsersAdminWithEmail();
        $collection = $this->translateCollection($data);
        
        return $res->withJson($collection);
    }

    public function updateUsers($req, $res, $args) {
        $values = $req->getParsedBody();
        $model = $this->getModel();
        
        foreach ($values as $user) {
            $User = $this->_mountEntity($user);
            
            $update = $model->doUpdate($User);
        }

        return $res->withJson($update);
    }

    public function update($req, $res, $args) {
        $values = $req->getParsedBody();

        $model = $this->getModel();
        $model->entity = $this->_mountEntity($values);
        
		$update = $model->doUpdate($model->entity);

        return $res->withJson($update);
    }

    public function _mountEntity($values){
        $model = $this->getModel();
        
        $entity = $model->mount($values);
        return parent::_mountEntity($entity);
    }

    public function getUserByNameOrCodeAction($req, $res, $args) {
        $results = $this->getModel()->findUsersByNameOrCode( $req->getParam('name'), $req->getParam('code') );
        $data = $this->translateCollection($results);

        return $res->withJson($data);
    }
    

}