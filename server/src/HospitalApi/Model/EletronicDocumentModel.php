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
            if( isset($user['id']) && $user['id']) {
                $User = $this->em->getRepository('HospitalApi\Entity\EletronicDocumentSignature')->findOneById($user['id']);
            } else {
                $User = new EletronicDocumentSignature();
                $user['document'] = $this->entity;
            }
            $User->construct($user);
            
            $user = $User;
        }
        $statusLevel = $values->draft ? 0 : 1;
        $values->status = $this->em->getRepository('HospitalApi\Entity\EletronicDocumentStatus')->findOneByLevel($statusLevel);

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
                // Level 2 is decime WaitingLevel
                $status = $StatusRepository->findOneByLevel(2);
                break;
            
            case 'finished':
                // Level 3 is decime FinishLevel
                $status = $StatusRepository->findOneByLevel(3);
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

}
