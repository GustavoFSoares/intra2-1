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

    public function getUsersForDocument($id) {
        $select = $this->em->createQueryBuilder();
        $select->select('u')
            ->from($this->getEntityPath(), 'eds')
            ->innerJoin('HospitalApi\Entity\User', 'u', 'WITH', 'eds.user = u')
            ->where('eds._document = :documentId')
            ->setParameter('documentId', $id);
        return $select->getQuery()->getResult();
    }

    public function getSignaturesByDocumentIdAndUsersId($documentId, Array $users) {
        $search = '';
        foreach ($users as $user) {
            $search[] = $user['id'];
        }

        $signatures = $this->getRepository()->findBy(['_document' => $documentId, 'user' => $search]);
        foreach ($signatures as &$signature) {
            $signature = $this->getRepository()->find( $signature->getId() );
        }
        return $signatures;
    }

}
