<?php

use HospitalApi\Entity\Sector;
use HospitalApi\Model\SectorModel;

$model = new SectorModel();

$sectors = [];

foreach ($sectors as $sector) {
    $sector = new Sector($sector['name']);
    $model->insert($sector);
}