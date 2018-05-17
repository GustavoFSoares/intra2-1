<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\RamalModel;

/**
 * <b>RamalController</b>
 */
class RamalController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new RamalModel());
    }

}