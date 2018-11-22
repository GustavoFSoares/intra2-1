<?php

use HospitalApi\Entity\OmbudsmanType;
use HospitalApi\Model\OmbudsmanTypeModel;

$model = new OmbudsmanTypeModel();

if(!$model->findBy()){
    $DemandsType = [
        ["id" => 'AMB', "name" => "Ambulatório/Eletivo"],
        ["id" => 'INT', "name" => "Internação"],
    ];
    
    foreach ($DemandsType as $demand) {
        $Demand = new OmbudsmanType();
        $Demand->setId($demand['id']);
        $Demand->setName($demand['name']);
        $model->doInsert($Demand);
    }
    echo "DemandType Inserted\n";
} else {
    echo "DemandType was ignored\n";
}
        