<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\Alert;
use Doctrine\DBAL\Event\SchemaAlterTableAddColumnEventArgs;

/**
* <b>AlertModel</b>
 */
class AlertModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Alert();
        parent::__construct();
    }

    /**
     * @method findOneByType()
     * Recebe um String $type de um alerta e 
     * retorna o último registro daquele tipo de alerta
     * @param $type
     * @return Collenction Alerta
     */
    public function findOneByType($type) {
        $collection = $this->getRepository()->findOneBy(
            [ 'type' => $type, 'c_removed' => '0' ],
            [ 'id' => 'DESC' ]            
        );
     
        return $collection;
    }
}