<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\Covenants;
use Doctrine\DBAL\Event\SchemaAlterTableAddColumnEventArgs;

/**
* <b>CovenantsModel</b>
 */
class CovenantsModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Covenants();
        parent::__construct();
    }

    public function findBy() {
        $collection = $this->getRepository()->findBy([]);

        return $collection;
    }
}