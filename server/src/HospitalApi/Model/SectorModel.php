<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\Sector;
use HospitalApi\Entity\BossSector;
use HospitalApi\Entity\Enterprise;

/**
 * <b>SectorModel</b>
 */
class SectorModel extends SoftdeleteModel
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
        
        $collection = $repository
            ->findBy(
                [
                    'Enterprise' => $id,
                    'c_removed' => '0'
                ],
                ['name' => 'ASC']
            );
            
        return $collection;
    }



}