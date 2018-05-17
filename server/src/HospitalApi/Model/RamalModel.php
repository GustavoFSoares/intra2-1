<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\Ramal;

/**
 * <b>RamalModel</b>
 */
class RamalModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Ramal;
        parent::__construct();
    }

    /**
     * @method findAll()
     * Realiza pesquisa na Tabela "Ramais" e os retorna ordenados pelo Setor
     * @return Collection Ramais
     */
    public function findAll() {
        return $this->getRepository()->findBy([ ], ['sector' => 'ASC']);
    }
}
