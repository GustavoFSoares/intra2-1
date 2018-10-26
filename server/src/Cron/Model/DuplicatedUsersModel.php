<?php
namespace Cron\Model;

use HospitalApi\Model\ModelAbstract;
use HospitalApi\Entity\DuplicatedUsers;

/**
* <b>DuplicatedUsersModel</b>
 */
class DuplicatedUsersModel extends ModelAbstract
{

    public $entity;
    static $instance;

    public function __construct() {
        $this->entity = new DuplicatedUsers();
        parent::__construct();
    }

    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
        
    }
    
    public static function addUsers($user1, $user2, $rotine) {
        $instance = self::getInstance();

        $userRepository = $instance->em->getRepository('HospitalApi\Entity\User');
        $rotine = $instance->em->getRepository('HospitalApi\Entity\Rotine')->find($rotine->getId());
        
        $duplicatedUsers = new DuplicatedUsers($userRepository->find($user1), $userRepository->find($user2), $rotine);
        
        $instance->doInsert($duplicatedUsers);
        return true;
    }

    public static function cleanTable() {
        $delete = self::getInstance()->em->createQueryBuilder();
        return $delete->delete('HospitalApi\Entity\DuplicatedUsers', 'du')->getQuery()->execute();
    }

}