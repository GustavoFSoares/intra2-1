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
        $justhese = ['displayname', 'samaccountname', 'department', 'description', 'physicaldeliveryofficename'];
        $result = ldap_search($this->_con, "dc=hmd,dc=local", $filter, $justhese);
        
        $info = ldap_get_entries($this->_con, $result);
        return $info;
    }
    
    public function getGroups(){
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
            
            $lastGroup = '';
            foreach ($info as $key => $result) {
                if($lastGroup != $result['department'][0]){
                    if($key != 'count'){
                        $lastGroup = $result['department'][0];

                        $groups[] = $this->getGroupArray($lastGroup);
                    }
                }
            
            }
                    
        }
        
        return $groups;
    }

     public function getUsers($letter){
        $this->_doRequest();
        $filter = "(sAMAccountName=$letter*)";
        $justhese = ['displayname', 'samaccountname', 'department', 'description', 'physicaldeliveryofficename'];
        $result = ldap_search($this->_con, "dc=hmd,dc=local", $filter, $justhese);
        
        $info = ldap_get_entries($this->_con, $result);
        return $info;
    }
    
    private function _doRequest() {
        $bind = ldap_bind($this->_con, $this->_getUser(AD_USER), AD_PASSWORD);
        if(!$bind){
            throw new Exception("Erro de Autenticação - Servidor LDAP não autenticado", 401);
        }
    }
        
    public function isActive($id){
        $this->_doRequest();
        $filter = "(sAMAccountName=$id)";
        $justhese = ['useraccountcontrol'];
        $result = ldap_search($this->_con, "dc=hmd,dc=local", $filter, $justhese);
        
        $info = ldap_get_entries($this->_con, $result);
        if(isset($info[0]['useraccountcontrol'][0])){
            $code = $info[0]['useraccountcontrol'][0];
        } else {
            return false;
        }
        
        $result =  false;
        switch ($code) {
            case '512':
                // Usuário Ativo
                $result = true;
                break;
            
            case '66048':
                // Usuário Ativo e Senha não expira
                $result = true;
                break;

            case '514':
                // Usuário Inativo
                $result = false;
                break;
            
            case '66050':
                // Usuário Inativo e Senha não expira
                $result = false;
                break;
            
        }
        
        return $result;
    }

    public function getLastWord($word) {
        $re = '/\s(\w+)$/m';
        preg_match_all($re, $word, $matches, PREG_SET_ORDER, 1);
        return $matches[0][1] ? $matches[0][1] : '';
    }

    private function _isHospital($word) {
        $re = '/(h[p,u]\w{0,2})/mi';
        preg_match_all($re, $word, $matches, PREG_SET_ORDER, 0);
        return $matches ? true : false;
        // return $matches[0][0] ? true : false;
    }

    private function _isCaps($word){
        $re = '/caps/mi';
        preg_match_all($re, $word, $matches, PREG_SET_ORDER, 0);
        return $matches ? true : false;
        // return $matches[0][0] ? true : false;
    }

    private function _isRioBranco($word) {
        $re = '/rio branco/mi';
        preg_match_all($re, $word, $matches, PREG_SET_ORDER, 0);
        return $matches ? true : false;
        // return $matches[0][0] ? true : false;
    }

    public function getGroupArray($nameGroup) {
        if($this->_isRioBranco($nameGroup)) {
            return ['name' => "UPA - Rio Branco", 'enterprise' => "UPA - Rio Branco"];
        } else if($this->_isCaps($nameGroup)){
            $enterprise = $nameGroup;
        } else if($this->_isHospital($nameGroup)){
            $enterprise = $this->getLastWord($nameGroup);
        } else {
            $enterprise = $nameGroup;
        }

        return ['name' => $nameGroup, 'enterprise' => $enterprise];
    }
}


					
					