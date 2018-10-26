<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\Rotine;

/**
* <b>RotineModel</b>
 */
class RotineModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Rotine();
        parent::__construct();
    }

}