<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\OmbudsmanUser;
/**
 * <b>OmbudsmanUserModel</b>
 */
class OmbudsmanUserModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new OmbudsmanUser;
        parent::__construct();
    }

}
