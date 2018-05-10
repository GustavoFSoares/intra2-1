<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\BossSector;

class BossSectorModel extends SoftdeleteModel
{

    public $entity;

    public function __construct()
    {

        $this->entity = new BossSector();
        parent::__construct();
    }

}