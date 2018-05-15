<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\LinkModel;

/**
 * <b>LinkController</b>
 */
class LinkController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new LinkModel());
    }

}