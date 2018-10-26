<?php
namespace Cron\Model;

use HospitalApi\Model\SoftdeleteModel;
use HospitalApi\Entity\Rotine;

/**
* <b>RotineModel</b>
 */
class RotineModel extends SoftdeleteModel
{

    public $entity;
    static $instance;

    public function __construct() {
        $this->entity = new Rotine();
        parent::__construct();
    }

    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
        
    }

    public static function startRotine($name, $from, $target){
        $rotine = new Rotine($name, $from, $target);

        self::getInstance()->entity = $rotine;
        self::getInstance()->doInsert($rotine);
        
        \Helper\LoggerHelper::initLogFile($target, null, $name, 'Y/m/d His');
        echo \Helper\LoggerHelper::writeFile("Inicio: ".date('Y-m-d H:i:s')."\n");
    }

    public static function endRotine() {
        self::getInstance()->entity->setTimeEnd(new \DateTime() );
        self::getInstance()->doUpdate(self::getInstance()->entity);

        echo \Helper\LoggerHelper::writeFile("--Rotina finalizada--\n");
        echo \Helper\LoggerHelper::writeFile("Fim: ".date('Y-m-d H:i:s')."\n");
    }


}