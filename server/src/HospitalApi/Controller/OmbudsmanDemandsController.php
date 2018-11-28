<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\OmbudsmanDemandsModel;

/**
 * <b>OmbudsmanDemandsController</b>
 */
class OmbudsmanDemandsController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new OmbudsmanDemandsModel());
    }

}