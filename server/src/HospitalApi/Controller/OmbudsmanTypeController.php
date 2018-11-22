<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\OmbudsmanTypeModel;

/**
 * <b>OmbudsmanTypeController</b>
 */
class OmbudsmanTypeController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new OmbudsmanTypeModel());
    }

}