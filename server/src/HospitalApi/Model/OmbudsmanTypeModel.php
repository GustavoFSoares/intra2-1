<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\OmbudsmanType;
/**
 * <b>OmbudsmanTypeModel</b>
 */
class OmbudsmanTypeModel extends ModelAbstract
{

    public $entity;

    public function __construct() {
        $this->entity = new OmbudsmanType;
        parent::__construct();
    }

    public function mount($values) {
        if(!$values['id']) {
            $values['id'] = substr($values['name'], 0, 3);
        }

        return $values;
    }

}
