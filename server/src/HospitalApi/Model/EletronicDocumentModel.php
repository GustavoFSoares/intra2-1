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
            
            case 'revoked':
                $status = $StatusRepository->findOneById('revoked');
                break;
            
            default:
                $status = $StatusRepository->findOneById('draft');
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
        $this->doUpdate($this->entity);

        return $this->entity->getStatus();
    }

    public function findBy($params) {
        $select = $this->showForJustWhoCanSee();
        $data = $select->getQuery()->getResult();
        
        return $data;
    }

    public function findById($id) {
        // $subquery = $this->em->createQueryBuilder();
        // $subquery->select('userSignature')
        //     ->from('HospitalApi\Entity\EletronicDocumentSignature', 'signature')
        //     ->innerJoin('HospitalApi\Entity\User', 'userSignature', 'WITH', 'userSignature = signature.user')
        //     ->where('signature.signed = 0')
        //     ->groupBy('signature._document')
        //     ->orderBy('signature.order', 'ASC');
        
        // $select = $this->em->createQueryBuilder();
        // $select->select('ed')
        //     ->from($this->getEntityPath(), 'ed')
        //     ->innerJoin("HospitalApi\Entity\User", "u", "with", "ed.user = u")
        //     ->innerJoin("HospitalApi\Entity\EletronicDocumentSignature", 'eds', 'WITH', ':id = ed')
        //     ->innerJoin("eds.user", 'us', 'WITH', 'u = :user OR us = :user')
        //     ->where( $select->expr()->eq( 'us', $select->expr()->any( $subquery->getDQL() )) )
        //     ->andwhere('eds.signed = 0')
        //     ->orwhere('u = :user')
        //     ->setParameter('user', $this->getSession() )
        //     ->setParameter('id', $id );
        $select = $this->showForJustWhoCanSee();
        $select
            ->andWhere('ed.id = :id')
            ->setParameter('id', $id);
        $data = $select->getQuery()->getOneOrNullResult();
        
        return $data;
    }

    public function showForJustWhoCanSee() {
        $subquery = $this->em->createQueryBuilder();
        $subquery->select('userSignature')
            ->from('HospitalApi\Entity\EletronicDocumentSignature', 'signature')
            ->innerJoin('HospitalApi\Entity\User', 'userSignature', 'WITH', 'userSignature = signature.user')
            ->where('signature.signed = 0')
            ->groupBy('signature._document')
            ->orderBy('signature.order', 'ASC');
        
        $select = $this->em->createQueryBuilder();
        $select->select('ed')
            ->from($this->getEntityPath(), 'ed')
            ->innerJoin("HospitalApi\Entity\User", "u", "with", "ed.user = u")
            ->leftJoin("HospitalApi\Entity\EletronicDocumentSignature", 'eds', 'WITH', 'eds._document = ed')
            ->leftJoin("eds.user", 'us', 'WITH', 'u = :user OR us = :user')
            ->where( $select->expr()->eq( 'us', $select->expr()->any( $subquery->getDQL() )) )
            ->andwhere('eds.signed = 0')
            ->orwhere('u = :user')
            ->setParameter('user', $this->getSession() );
        return $select;
    }

}
