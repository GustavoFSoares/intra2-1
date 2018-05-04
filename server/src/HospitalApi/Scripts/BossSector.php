<?php

use HospitalApi\Entity\BossSector;
use HospitalApi\Model\BossSectorModel;

$model = new BossSectorModel();

$bossSectors = [];

foreach ($bossSectors as $bossSector) {
    $bossSector = new BossSector(null, $bossSector['name'], $bossSector['email']);
    $model->insert($bossSector);
}