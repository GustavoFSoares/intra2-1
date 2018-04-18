<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Link;

/**
 * <b>LinkModel</b>
 * Classe responsável pela manipulação dos Links de acesso
 */
class LinkModel extends ModelAbstract
{

    public $entity;

    public function __construct() {
        $this->entity = new Link;
        parent::__construct();
    }
}
