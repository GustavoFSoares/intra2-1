<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\EletronicDocumentStatusModel;

/**
 * <b>EletronicDocumentStatusController</b>
 */
class EletronicDocumentStatusController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new EletronicDocumentStatusModel());
    }

}