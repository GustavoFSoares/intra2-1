<?php

use HospitalApi\Entity\OmbudsmanOrigin;
use HospitalApi\Model\OmbudsmanOriginModel;

$model = new OmbudsmanOriginModel();

if(!$model->findBy()){
    $DemandsOrigin = [
        ["id" => 'AMB', "name" => "Ambulatorio/Eletivo"],
        ["id" => 'INT', "name" => "Pacientes Internados"],
    ];
    
    foreach ($DemandsOrigin as $demand) {
        $Demand = new OmbudsmanOrigin();
        $Demand->setId($demand['id']);
        $Demand->setName($demand['name']);
        $model->doInsert($Demand);
    }
    echo "DemandOrigin Inserted\n";
} else {
    echo "DemandOrigin was ignored\n";
}
        