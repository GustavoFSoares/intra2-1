<?php
namespace Cron\Model;

use HospitalApi\Model\ModelAbstract;
use HospitalApi\Entity\User;

class UserModel extends ModelAbstract
{

    public $entity;
    
    public function __construct(){
        $this->entity = new User();
        parent::__construct();
    }
    
    public function findByUserId($UserId){
        return $this->getRepository()->findOneByUserId($UserId);
    }

}