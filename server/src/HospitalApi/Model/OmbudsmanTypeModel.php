<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\OmbudsmanType;
/**
 * <b>OmbudsmanTypeModel</b>
 */
class OmbudsmanTypeModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new OmbudsmanType;
        parent::__construct();
    }

    public function mount($values) {
        if(!isset($values['id'])) {
            $values['id'] = strtoupper( substr($values['name'], 0, 3) );
            if($Type = $this->getRepository()->find($values['id'])) {
                $Type
                    ->setName($values['name'])
                    ->setC_removed(false);
                $this->doUpdate($Type);
                return [];
            }
        }

        return $values;
    }

}
