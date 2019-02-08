<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\EletronicDocumentModel;
use HospitalApi\Model\EletronicDocumentSignatureModel;
use HospitalApi\Entity\User;
use HospitalApi\Entity\EletronicDocument;
use HospitalApi\Entity\EletronicDocumentAmendment;

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

        if($values['agree']) {
            
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
                $this->sendEmailToNextUser($entity);
            }

        } else {
            $this->getModel()->setLike('revoked', $entity->getId());

            $rason = $values['message'];

            $this->sendEmailRevoked($entity, $this->getSession(), $rason );
        }

        $this->makeLog($values['document_id'], $values['agree'], $values['message']);

        $data = $this->translateCollection( $entity->getStatus() );
        return $res->withJson($data);
    }

    public function updateAmendmentAction($req, $res, $args) {
        $values = $req->getParsedBody();
        $this->loadEntity($values);

        $SignatureModel = new EletronicDocumentSignatureModel();
        $AmendmentModel = new \HospitalApi\Model\EletronicDocumentAmendmentModel();

        foreach ($values['amendmentList'] as $key => &$amendment) {
            // Se documento já foi cadastrado
            if( !isset($amendment['id']) || $amendment['id'] == false ) {
                $isNewAmendment = true;

                $amendment['signatureList'] = $SignatureModel->getSignaturesByDocumentIdAndUsersId($values['id'], $amendment['signatureUsers']);

                // Obtem um objeto de Repository com assinaturas anexadas a Emenda
                foreach ($amendment['signatureList'] as $key => &$signature) {

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

                if($isNewAmendment === true) {
                    if( $amendment->getSignatureList() == null ) {
                        $values['signatureList'] = $SignatureModel->clearSignatures( $amendment->getDocument()->getId() );
                        $user = $amendment->getDocument()->getUser();
                    } else {
                        $user = $amendment->getSignatureList()[0]->getUser();
                    }

                    $this->sendEmailForResign( $amendment, $user );
                }
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

    public function sendEmailToNextUser(EletronicDocument $eletronicDocument) {
        $SignatureModel = new EletronicDocumentSignatureModel();
                
        $signatureTemplate = new \HospitalApi\Template\EletronicDocumentSignatureEmailTemplate($eletronicDocument, $SignatureModel->getNextUserToSign( $eletronicDocument->getId() ));
        return EmailController::sendEmailAction($signatureTemplate);
    }
    
    public function sendEmailForResign(EletronicDocumentAmendment $amendment, User $userToResign) {
        $amendmentTemplate = new \HospitalApi\Template\EletronicDocumentSignatureToAmendmentEmailTemplate(
                $amendment, 
                $userToResign
            );
        return EmailController::sendEmailAction($amendmentTemplate);
    }
    
    public function sendEmailRevoked(EletronicDocument $eletronicDocument, User $userToResign, $rason) {
        $revokedTemplate = new \HospitalApi\Template\EletronicDocumentSignatureRevokedEmailTemplate(
                $eletronicDocument, 
                $userToResign, 
                $rason
            );
        return EmailController::sendEmailAction($revokedTemplate);
    }

    public function insert($req, $res, $args) { 
        $response = parent::insert($req, $res, $args);
        if($this->getModel()->entity->getStatus()->getId() != 'draft') {
            $this->sendEmailToNextUser($this->getModel()->entity);
        }

        return $response;
    }
    public function update($req, $res, $args) { 
        $response = parent::update($req, $res, $args);
        if($this->getModel()->entity->getStatus()->getId() != 'draft') {
            $this->sendEmailToNextUser($this->getModel()->entity);
        }

        return $response;
    }

}