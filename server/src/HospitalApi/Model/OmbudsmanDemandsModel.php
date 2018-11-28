<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\OmbudsmanDemands;
/**
 * <b>OmbudsmanDemandsModel</b>
 */
class OmbudsmanDemandsModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new OmbudsmanDemands;
        parent::__construct();
    }

}
