<?php
namespace HospitalApi\Controller;

use Exception;
/**
 * <b>ActiveDirectoryController</b>
 */
class ActiveDirectoryController
{

    private $_con;
    private $user;
    private $password;
    
    public function __construct() {
        $adminUser = "servweb";
        $ldaprdn = 'hmd'."\\".$adminUser;
        $adminPass = "hu@esc@gamp@web";

        $this->_con = ldap_connect(AD_HOST);
        ldap_set_option($this->_con, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->_con, LDAP_OPT_REFERRALS, 0);
    }

    private function _getUser($user) {
        return "hmd\\$user";
    }

    public function doAuth($user) {
        if(!$user->password){
            return false;
        }
        $bind = ldap_bind($this->_con, $this->_getUser($user->id), $user->password);
        
        return $bind;
    }

    public function getUserContents($login){
        $this->_doRequest();
        $filter = "(sAMAccountName=$login)";
        $justhese = ['displayname', 'samaccountname', 'department', 'description'];
        $result = ldap_search($this->_con, "dc=hmd,dc=local", $filter, $justhese);
        
        $info = ldap_get_entries($this->_con, $result);
        return $info;
    }
    
    public function getSectors(){
        $this->_doRequest();
        $alph = ['a', 'b', 'c', 'd', 'e', 'f',
        		 'g', 'h', 'i', 'j', 'k', 'l',
        		 'm', 'n', 'o', 'p', 'q', 'r',
        		 's', 't', 'u', 'v', 'w', 'x',
        		 'y', 'z'];
        
        
        foreach ($alph as $letter) {
            $filter = "(department=$letter*)";
            $justhese = ['department'];
            $result = ldap_search($this->_con, "dc=hmd,dc=local", $filter, $justhese);
            
            $info = ldap_get_entries($this->_con, $result);
            
            foreach ($info as $key => $result) {
                if($last != $result['department'][0]){
                    if($key != 'count'){
                        $last = $result['department'][0];
                        
                        $re = '/\s(\w+)$/m';
                        preg_match_all($re, $last, $matches, PREG_SET_ORDER, 1);
                        $groups[] = ['name' => $last, 'enterprise' => $matches[0][1]];
                    }
                }
            
            }
                    
        }
    
        return $groups;
    }

    private function _doRequest() {
        $bind = ldap_bind($this->_con, $this->_getUser(AD_USER), AD_PASSWORD);
        if(!$bind){
            throw new Exception("Erro de Autenticação - Servidor LDAP não autenticado", 401);
        }
    }
        
}


					
					