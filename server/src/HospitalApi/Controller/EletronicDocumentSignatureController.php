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

    public function getUserSignedAction($req, $res, $args) {
        $documentId = $args['document-id'];
        
        $collection = $this->getModel()->getUserSigned($documentId);
        $data = $this->translateCollection($collection);
        
        return $res->withJson( $data );
    }

    public function getNextUserToSignAction($req, $res, $args) {
        $userCollection = $this->getModel()->getNextUserToSign($args['document-id']);
        
        $user = $this->translateCollection($userCollection);
        return $res->withJson($user);
    }

}