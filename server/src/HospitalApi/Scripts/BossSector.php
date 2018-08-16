<?php

use HospitalApi\Entity\BossSector;
use HospitalApi\Model\BossSectorModel;

$model = new BossSectorModel();
if(false){
    $bossSectors = [
        [ 'name' => "NoBoss", 'email' => "NoBoss@gampcanoas.com.br", ]
    ];
    
    foreach ($bossSectors as $bossSector) {
        $bossSector = new BossSector(null, $bossSector['name'], $bossSector['email']);
        $model->doInsert($bossSector);
    }
    echo "BossSector Inserted\n";
} else {
    echo "BossSector was ignored\n";
}