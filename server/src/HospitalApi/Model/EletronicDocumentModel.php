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
    private $_blockedStatus = [];
    private $_alowedStatusToSign = [];

    public function __construct() {
        $this->entity = new EletronicDocument;
        
        $this->_blockedStatus = [ 'canceled', 'revoked', 'finished', ];
        $this->_alowedStatusToSign = ['sending', 'waiting-signature', 'waiting-correction'];
        parent::__construct();
    }

    public function getBlockedStatus() {
        return $this->_blockedStatus;
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
        $id = $this->getSession()->getId();
        $signatureList = $signatureList->filter(function($entry) use ($id)  {
            return $entry->getUser()->getId() == $id;
        });
        return $signatureList->first();
    }

    public function setLike($levelName, $id, $message = '') {
        if($this->entity->getId() == null) {
            $this->entity = $this->getRepository()->find($id);
        }

        \Helper\LoggerHelper::initLogFile('eletronic-documents', null, $this->entity->getId() );
        $StatusRepository = $this->em->getRepository('HospitalApi\Entity\EletronicDocumentStatus');
        switch ($levelName) {
            case 'sign':
                $message = "{$this->getSession()->getName()}: Assinou documento";
                $status = $StatusRepository->findOneById('sending');
                break;
            
            case 'waiting-signature':
                $message = "{$this->getSession()->getName()}: Visualizou documento";
                $status = $StatusRepository->findOneById('waiting-signature');
                break;
            
            case 'correction':
                $message = "{$this->getSession()->getName()}: Criou emenda";
                $status = $StatusRepository->findOneById('waiting-correction');
                break;
            
            case 'finished':
                $message = "{$this->getSession()->getName()}: Assinou documento";
                \Helper\LoggerHelper::writeFile($message, true);
                $message = "Documento Finalizado";

                $this->entity->setFinished(true);
                $status = $StatusRepository->findOneById('finished');
                break;
            
            case 'revoked':
                $message = "{$this->getSession()->getName()}: Documento Negado - $message";
                $this->entity->setCanceled(true);
                $status = $StatusRepository->findOneById('revoked');
                break;
            
            case 'canceled':
                $message = "Cancelado pelo Criador";
                $this->entity->setCanceled(true);
                $status = $StatusRepository->findOneById('canceled');
                break;
            
            case 'archived':
                $this->entity->setArchived(true);
                $status = false;
                break;
            
            default:
                $status = $StatusRepository->findOneById('draft');
                break;
        }

        if($status) {
            $this->entity->setStatus($status);
        }
        if($message) { 
            \Helper\LoggerHelper::writeFile($message, true);
        }
        $this->doUpdate($this->entity);

        return $this->entity->getStatus();
    }

    public function findEletronicDocuments($params) {
        $select = $this->showForJustWhoCanSee();
        $data = $select->getQuery()->getResult();
        
        return $data;
    }

    public function findById($id) {
        if( $this->getSession()->isAdmin() ) {
            $data = parent::findById($id);
        } else {
            $select = $this->showForJustWhoCanSee();
            $select
                ->andWhere('ed.id = :id')
                ->setParameter('id', $id);
            $data = $select->getQuery()->getOneOrNullResult();
        }
        
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
            ->andwhere( $select->expr()->in('ed.status', $this->_alowedStatusToSign) )
            ->orwhere('u = :user')
            ->setParameter('user', $this->getSession() )
            ->andWhere('ed.c_removed = 0');
        return $select;
    }

}
