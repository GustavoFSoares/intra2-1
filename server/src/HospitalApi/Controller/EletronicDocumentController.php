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


    public function signDocumentAction($req, $res, $args) {
        $values = $req->getParsedBody();
        $this->storeUser($values);
        
        $model = $this->getModel();
        switch ($args['type']) {
            case 'user-of-list':
                $entity = $model->signLikeUser($values);
                break;
            
            case 'creator':
                $entity = $model->signLikeCreator($values);
                break;
            
            default:
                throw new Exception("type ({$args['type']}) not comapible", 400);
                break;
        }

        $signatureList = $entity->getSignatureList();     
        $signaturesSigned = $signatureList->filter(function($entry) {
            return $entry->isSigned() == true;
        });
        
        if($signatureList->count() == $signaturesSigned->count()) {
            $this->getModel()->setLike('finished', $entity->getId());
        } else {
            $this->getModel()->setLike('waiting', $entity->getId());
        }

        
        $this->makeLog($values['document_id'], $values['agree'], $values['message']);

        return $res->withJson($entity);
    }

    public function makeLog($id, $agree, $message) {
        \Helper\LoggerHelper::initLogFile('eletronic-documents', null, $id);
        if($agree) {
            $message .= "{$this->getContainer()['session']->get()->getName()}: Concordou com documento";
        } else {
            $message = "{$this->getContainer()['session']->get()->getName()}: Negou o documento. Justificativa: - $message";
        }

        \Helper\LoggerHelper::writeFile($message, true);
    }

}