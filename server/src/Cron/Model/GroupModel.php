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

    public function findGroupsId() {
        $query = $this->em->createQueryBuilder();
        $query->select('g.groupId')
            ->from('HospitalApi\Entity\Group', 'g');
        $values = $query->getQuery()->getResult();

        $data = [];
        foreach ($values as $key => $value) {
            $data[] = $value['groupId'];
        }

        return $data;
    }

}