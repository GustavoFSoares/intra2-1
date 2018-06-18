<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\StatusMessage;
/**
 * <b>StatusMessagelModel</b>
 */
class StatusMessageModel extends ModelAbstract
{
// StatusMessageModel
    public $entity;

    public function __construct() {
        $this->entity = new StatusMessage;
        parent::__construct();
    }

    public function getStatus($id) {
        $status = $this->findById($id);
        
        if(!$status) {
            die('status not found');
        }
        
        return $status;
    }

}
