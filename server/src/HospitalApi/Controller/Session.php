<?php
namespace HospitalApi\Controller;

use HospitalApi\BasicApplicationAbstract;
use HospitalApi\Entity\User;

/**
 * <b>Session</b>
 */
class Session extends BasicApplicationAbstract {

    protected static $user;
    
    public function __construct() {
        if (isset(self::$user)) {
            return $this;
        }
    }

    public function _init($user) {
        self::$user = $user;

        return $this;
    }

    public function get() {
        if( self::$user == null ) {
            throw new \Exception("Authentication Failed. You must be Logged", 401);
            
        }
        return self::$user;
    }

    public function gotPermission($moduleAccessed) {
        $moduleAccessed = strtoupper($moduleAccessed);
        $permissions = $this->getSpecialDataPermissions();

        if( !isset($permissions[$moduleAccessed]) ) {
            throw new \Exception("Module Accessed not Found", 404);
        }

        foreach ($permissions[$moduleAccessed] as $key => $groupsWithAccess) {
            if( is_array($groupsWithAccess) ) {
                if( in_array($this->get()->getGroup()->getGroupId(), $groupsWithAccess) ) {
                    return $key;
                }
            }
        }
        return 'USER';
    }





}