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

        // Conta Quantidade de Assinaturas
        $signatureList = $entity->getSignatureList();     
        $signaturesSigned = $signatureList->filter(function($entry) {
            return $entry->isSigned() == true;
        });
        
        //Se Quantidade de Assinaturas == Total Assinaturas --> Status Finalizado
        if($signatureList->count() == $signaturesSigned->count()) {
            $this->getModel()->setLike('finished', $entity->getId());
        } else {
            $this->getModel()->setLike('waiting', $entity->getId());
        }

        
        $this->makeLog($values['document_id'], $values['agree'], $values['message']);
        return $res->withJson(true);
    }

    public function updateAmendmentAction($req, $res, $args) {
        $values = $req->getParsedBody();
        $this->loadEntity($values);

        $SignatureModel = new \HospitalApi\Model\EletronicDocumentSignatureModel();
        $AmendmentModel = new \HospitalApi\Model\EletronicDocumentAmendmentModel();

        foreach ($values['amendmentList'] as $key => &$amendment) {
            // Se documento já foi cadastrado
            if( !isset($amendment['id']) || $amendment['id'] == false ) {

                $amendment['signatureList'] = $SignatureModel->getSignaturesByDocumentIdAndUsersId($values['id'], $amendment['signatureUsers']);
                // `----------> Se signatureList == null |- Apagar todas assinaturas e enviar email para criador do documento


                // Obtem um objeto de Repository com assinaturas anexadas a Emenda
                foreach ($amendment['signatureList'] as &$signature) {
                    
                    // Apaga a Assinatura do Responsável e às Reordena
                    $signature = $SignatureModel->undoSignature($signature);
                    array_filter($values['signatureList'], function(&$entry) use ($signature) {
                        if($signature->getId() == $entry['id']) {
                            $entry = $signature;
                            return;
                        }
                    });
                }
                $amendment['document'] = $this->getModel()->entity;
                unset($amendment['signatureUsers']);

                // Monta objeto de Emenda
                $amendment = $AmendmentModel->entity->construct($amendment);
            } else {

                // Carrega Emendas já cadastradas
                $amendment = $AmendmentModel->getRepository()->find($amendment['id']);
            }
        }
        $entity = $this->_mountEntity($values);
        $this->getModel()->doUpdate($entity);
        $this->getModel()->setLike('correction', $entity->getId());

        return $res->withJson(true);
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

    public function setLikeWaitingSignatureAction($req, $res, $args) {
        $status = $this->getModel()->setDocumentLikeWaitingSignature($args['document-id']);
        $data = $this->translateCollection($status);

        return $res->withJson($data);
    }

}