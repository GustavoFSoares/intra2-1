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

    public function update($req, $res, $args) {
        $values = $req->getParsedBody();

        $model = $this->getModel();
        $model->entity = $this->_mountEntity($values);
        
        $group = $model->em->getRepository('HospitalApi\Entity\Group')->findOneById($values['group']['id']);
        $model->entity->setGroup($group);
        
		$update = $model->doUpdate($model->entity);

        return $res->withJson($update);
    }

    public function _mountEntity($values){
        $model = $this->getModel();
        
        $entity = $model->mount($values);
        return parent::_mountEntity($entity);
    }

}