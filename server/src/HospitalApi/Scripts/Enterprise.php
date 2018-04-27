<?php

use HospitalApi\Entity\Enterprise;
use HospitalApi\Model\EnterpriseModel;

$model = new EnterpriseModel();

$enterprises = [ ];

foreach ($enterprises as $enterprise) {
    $enterprise = new Enterprise($enterprise['name']);
    $model->insert($enterprise);
}