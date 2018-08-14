<?php

use HospitalApi\Entity\TrainingType;
use HospitalApi\Model\TrainingTypeModel;

$model = new TrainingTypeModel();

if(!$model->findAll()){
    $Trainings = [
        ['name' => "Padrões de Atendimento"],
        ['name' => "Noções Básicas de Combate a Incêndio"],
        ['name' => "Coleta de Material Biológico"],
        ['name' => "Segurança e Saúde no Trabalho em Hospitais NR32"],
        ['name' => "Política Nacional de Humanização"],
        ['name' => "Suporte Básico de Vida"],
        ['name' => "NR 06"],
        ['name' => "Prevenção e Cuidados com Vírus Respiratórios"],
        ['name' => "Gestão do Ponto"],
        ['name' => "Outros"]
    ];
    
    foreach ($Trainings as $training) {
        $Training = new TrainingType();
        $Training
            ->setName($training['name']);
        $model->doInsert($Training);
    }
    echo "TrainingType Inserted\n";
} else {
    echo "TrainingType was ignored\n";
}