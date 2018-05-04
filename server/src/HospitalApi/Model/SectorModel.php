<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\Sector;
use HospitalApi\Entity\BossSector;
use HospitalApi\Entity\Enterprise;

class SectorModel extends ModelAbstract
{

    public $entity;

    public function __construct() {
        $enterprise = new Enterprise();
        $bossSector = new BossSector();

        $this->entity = new Sector($enterprise, $bossSector);
        parent::__construct();
    }

    public function findSectorsByEnterprise($id = null) {
        $repository = $this->em->getRepository("HospitalApi\Entity\Sector");
        
        $collection = $repository->findBy(['Enterprise' => $id]);
        return $collection;
    }



}