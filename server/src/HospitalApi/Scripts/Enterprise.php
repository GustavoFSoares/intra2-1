<?php

use HospitalApi\Entity\Enterprise;
use HospitalApi\Model\EnterpriseModel;

$model = new EnterpriseModel();

$enterprises = [
    [ 'id' => 'hu', 'name' => 'Hospital Universitário - HU' ],
    [ 'id' => 'hpsc', 'name' => 'Hospital Pronto Socorro - HPSC' ],
    [ 'id' => 'caps-amanhecer', 'name' => 'CAPS - Amanhecer' ],
    [ 'id' => 'caps-novo-tempo', 'name' => 'CAPS - Novo Tempo' ],
    [ 'id' => 'caps-girassois', 'name' => 'CAPS - Recanto dos Girassóis' ],
    [ 'id' => 'caps-travessia', 'name' => 'CAPS - Travessia' ],
    [ 'id' => 'upa-rio-branco', 'name' => 'UPA - Rio Branco' ],
 ];

foreach ($enterprises as $enterprise) {
    $enterprise = new Enterprise($enterprise['id'], $enterprise['name']);
    $model->insert($enterprise);
}