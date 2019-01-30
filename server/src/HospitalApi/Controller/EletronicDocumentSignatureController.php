<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\EletronicDocumentSignatureModel;

/**
 * <b>EletronicDocumentSignatureController</b>
 */
class EletronicDocumentSignatureController extends ControllerAbstractLongEntity
{
    public function __construct() {
        parent::__construct(new EletronicDocumentSignatureModel());
    }

    public function getUserForDocumentAction($req, $res, $args) {
        $documentId = $args['document-id'];
        
        $collection = $this->getModel()->getUsersForDocument($documentId);
        $data = $this->translateCollection($collection);
        
        return $res->withJson( $data );
    }
}