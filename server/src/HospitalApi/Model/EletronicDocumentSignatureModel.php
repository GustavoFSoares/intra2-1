<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\EletronicDocumentSignature;
/**
 * <b>EletronicDocumentModel</b>
 */
class EletronicDocumentSignatureModel extends ModelAbstract
{

    public $entity;
    public $inverseOrder = true;

    public function __construct() {
        $this->entity = new EletronicDocumentSignature;
        parent::__construct();
    }

    public function getUserSigned($id) {
        $select = $this->em->createQueryBuilder();
        $select->select('u')
            ->from($this->getEntityPath(), 'eds')
            ->innerJoin('HospitalApi\Entity\EletronicDocument', 'ed', 'WITH', 'eds._document = ed ')
            ->innerJoin('HospitalApi\Entity\User', 'u', 'WITH', '(eds.user = u AND eds.signed = 1) OR ed.user = u')
            ->where('eds._document = :documentId')
            ->setParameter('documentId', $id);
        return $select->getQuery()->getResult();
    }

    public function getSignaturesByDocumentIdAndUsersId($documentId, Array $users) {
        $search = '';
        foreach ($users as $user) {
            $search[] = $user['id'];
        }

        $signatures = $this->getRepository()->findBy(['_document' => $documentId, 'user' => $search], ['order' => 'ASC']);
        foreach ($signatures as &$signature) {
            $signature = $this->getRepository()->find( $signature->getId() );
        }
        return $signatures;
    }

    public function getNextUserToSign($documentId) {
        $select = $this->em->createQueryBuilder();
        $select->select('u')
            ->from($this->getEntityPath(), 's')
            ->innerJoin('HospitalApi\Entity\User', 'u', 'WITH', 's.user = u')
            ->where('s._document = :documentId')
            ->setParameter('documentId', $documentId)
            ->andWhere('s.signed = 0')
            ->setMaxResults('1')
            ->orderBy('s.order', 'ASC');
        return $select->getQuery()->getOneOrNullResult();
    }

    public function undoSignature(EletronicDocumentSignature $signature) {
        $signature
            ->setSigned(false)
            ->setAgree(null);
        $this->doUpdate($signature);

        return $signature;
    }

    public function clearSignatures($documentId) {
        $update = $this->em->createQueryBuilder();
        $update->update($this->getEntityPath(), 'eds')
            ->set('eds.signed', 0)
            ->set('eds.agree', ':null')
            ->where('eds._document = :documentId')
            ->setParameter('documentId', $documentId)
            ->setParameter('null', null);
        $update->getQuery()->execute();
            
        $update = $this->em->createQueryBuilder();
        $update->update('HospitalApi\Entity\EletronicDocument', 'ed')
            ->set('ed.signed', 0)
            ->where('ed.id = :documentId')
            ->setParameter('documentId', $documentId);
        $update->getQuery()->execute();

        $select = $this->em->createQueryBuilder();
        $select->select('s')
            ->from($this->getEntityPath(), 's')
            ->where('s._document = :documentId')
            ->setParameter('documentId', $documentId);
        return $select->getQuery()->getResult();
    }

}
