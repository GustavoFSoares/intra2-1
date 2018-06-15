<?php
namespace HospitalApi;

class BasicApplicationAbstract
{

    public function isDebug(){
        return DEBUG_ACTIVE;
    }

    public function getDebugEmail(){
        return DEBUG_EMAIL;
    }

    public function ADAllowed(){
        return AD;
    }

}