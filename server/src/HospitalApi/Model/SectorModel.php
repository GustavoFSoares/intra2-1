<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\Sector;

class SectorModel extends ModelAbstract
{

    public $entity;

    public function __construct()
    {

        $this->entity = new Sector();
        parent::__construct();
    }

}