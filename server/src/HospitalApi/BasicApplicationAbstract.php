<?php
namespace HospitalApi;

class BasicApplicationAbstract
{

    public function isDebug(){
        return DEBUG_ACTIVE;
    }

    public function getEmailDefault(){
        return [
            'name' => EMAIL_DEFAULT_NAME,
            'email' => EMAIL_DEFAULT_EMAIL,
            'password' => EMAIL_DEFAULT_PASSWORD,
            'host' => EMAIL_DEFAULT_HOST,
        ];
    }
    
    public function getDebugEmail(){
        return DEBUG_EMAIL;
    }

    public function ADAllowed(){
        return AD;
    }

}