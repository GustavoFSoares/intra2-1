<?php

use HospitalApi\Entity\BossSector;
use HospitalApi\Model\BossSectorModel;

$model = new BossSectorModel();

$bossSectors = [
    [ 'name' => "NoBoss", 'email' => "NoBoss@gampcanoas.com.br", ]
];

foreach ($bossSectors as $bossSector) {
    $bossSector = new BossSector(null, $bossSector['name'], $bossSector['email']);
    $model->insert($bossSector);
}