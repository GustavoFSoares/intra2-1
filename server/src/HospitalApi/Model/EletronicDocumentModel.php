<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\EletronicDocument;
use HospitalApi\Entity\EletronicDocumentSignature;
/**
 * <b>EletronicDocumentModel</b>
 */
class EletronicDocumentModel extends SoftdeleteModel
{

    public $entity;
    public $inverseOrder = true;

    public function __construct() {
        $this->entity = new EletronicDocument;
        parent::__construct();
    }

    public function mount($values) {
        $values = (object)$values;
        
        foreach ($values->signatureList as &$user) {
            if($user instanceof \HospitalApi\Entity\EntityAbstract) {
                continue;
            } else if( isset($user['id']) && $user['id']) {
                $User = $this->em->getRepository('HospitalApi\Entity\EletronicDocumentSignature')->findOneById($user['id']);
            } else {
                $User = new EletronicDocumentSignature();
                $user['document'] = $this->entity;
            }
            $User->construct($user);
            
            $user = $User;
        }
        
        if ($values->draft) {
            $values->status = $this->em->getRepository('HospitalApi\Entity\EletronicDocumentStatus')->findOneById('draft');
        } else {
            if( !isset($values->status) || !$values->status instanceof \HospitalApi\Entity\EntityAbstract) {
                $values->status = $this->em->getRepository('HospitalApi\Entity\EletronicDocumentStatus')->findOneById('sending');
            } 
        }

        return $values;
    }

    public function signLikeUser($data) {
        $this->entity = $this->getRepository()->find($data['document_id']);
        $signature = $this->findUserOnSignatureList($this->entity->getSignatureList());
        $signature
            ->setAgree($data['agree'])
            ->setSigned(true);
        $this->doUpdate($signature);
        return $this->entity;
    }

    public function signLikeCreator($data) {
        $this->entity = $this->getRepository()->find($data['document_id']);
        $this->entity->setSigned(true);
        $this->doUpdate($this->entity);
        return $this->entity;

    }

    public function findUserOnSignatureList($signatureList) {
        $id = $this->getContainer()['session']->get()->getId();
        $signatureList = $signatureList->filter(function($entry) use ($id)  {
            return $entry->getUser()->getId() == $id;
        });
        return $signatureList->first();
    }

    public function setLike($levelName, $id) {
        if($this->entity->getId() == null) {
            $this->entity = $this->getRepository()->find($id);
        }

        $StatusRepository = $this->em->getRepository('HospitalApi\Entity\EletronicDocumentStatus');
        switch ($levelName) {
            case 'waiting':
                $status = $StatusRepository->findOneById('sending');
                break;
            
            case 'correction':
                $status = $StatusRepository->findOneById('waiting-correction');
                break;
            
            case 'finished':
                $status = $StatusRepository->findOneById('finished');
                break;
            
            default:
                // Level 0 is decime DraftLevel
                $status = $StatusRepository->findOneByLevel(0);
                break;
        }
        
        $this->entity->setStatus($status);
        $this->doUpdate($this->entity);

        return $this->entity;
    }

    public function setDocumentLikeWaitingSignature($documentId) {
        $this->entity = $this->getRepository()->find($documentId);
        
        $waitingSignatureStatus = $this->em->getRepository('HospitalApi\Entity\EletronicDocumentStatus')->findOneById('waiting-signature');
        $this->entity->setStatus($waitingSignatureStatus);
        
        return $this->entity->getStatus();
    }

}
