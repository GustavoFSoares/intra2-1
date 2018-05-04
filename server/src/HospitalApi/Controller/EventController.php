<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\EventModel;

class EventController extends ControllerAbstract
{
    public function __construct()
    {
        parent::__construct(new EventModel());
    }

}