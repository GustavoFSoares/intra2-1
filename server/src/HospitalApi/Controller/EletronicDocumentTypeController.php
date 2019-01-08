<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\EletronicDocumentTypeModel;

/**
 * <b>EletronicDocumentTypeController</b>
 */
class EletronicDocumentTypeController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new EletronicDocumentTypeModel());
    }

}