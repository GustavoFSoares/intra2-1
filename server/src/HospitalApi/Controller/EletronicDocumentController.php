<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\EletronicDocumentModel;

/**
 * <b>EletronicDocumentController</b>
 */
class EletronicDocumentController extends ControllerAbstractLongEntity
{
    public function __construct() {
        parent::__construct(new EletronicDocumentModel());
    }

}