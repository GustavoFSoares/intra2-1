<?php
namespace HospitalApi;

class BasicApplicationAbstract
{

    public function isDebug(){
        return DEBUG['active'];
    }

    public function getDebugEmail(){
        return DEBUG['email'];
    }

}