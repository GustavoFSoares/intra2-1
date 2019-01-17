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

    public function __construct() {
        $this->entity = new EletronicDocument;
        parent::__construct();
    }

    public function mount($values) {
        $values = (object)$values;

        foreach ($values->userList as &$user) {
            $User = new EletronicDocumentSignature();
            $user['document'] = $this->entity;
            $User->construct($user);
            
            $user = $User;   
        }
        if(!isset($values->status) || !$values->status) {
            $statusLevel = $values->draft ? 0 : 1;
            $values->status = $this->em->getRepository('HospitalApi\Entity\EletronicDocumentStatus')->findOneByLevel(1);
        }

        return $values;
    }

}
