<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\Event;

/**
 * <b>EventModel</b>
 */
class EventModel extends SoftdeleteModel {

    public $entity;
    
    public function __construct(){

        $this->entity = new Event();
        parent::__construct();
    }

}