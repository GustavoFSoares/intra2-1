<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Ombudsman;
/**
 * <b>OmbudsmanModel</b>
 */
class OmbudsmanModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Ombudsman;
        parent::__construct();
    }

}
