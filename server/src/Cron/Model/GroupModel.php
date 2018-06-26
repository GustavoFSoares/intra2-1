<?php
namespace Cron\Model;

use HospitalApi\Model\ModelAbstract;
use HospitalApi\Entity\Group;

class GroupModel extends ModelAbstract
{

    public $entity;
    
    public function __construct(){
        $this->entity = new Group();
        parent::__construct();
    }
    
    public function findByGroupId($groupId){
        return $this->getRepository()->findOneByGroupId($groupId);
    }

}