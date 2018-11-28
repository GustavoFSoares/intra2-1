<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\OmbudsmanOriginModel;

/**
 * <b>OmbudsmanOriginController</b>
 */
class OmbudsmanOriginController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new OmbudsmanOriginModel());
    }

}