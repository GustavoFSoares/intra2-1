<?php

use HospitalApi\Entity\Event;
use HospitalApi\Model\EventModel;

$model = new EventModel();

if(!$model->findAll()){
    $events = [
        ["name" => "Desenvolvimento de Lesão por Pressão(UP)"],
        ["name" => "Erro de Medicação (medicamento errado, paciente errado, medicação não administrada)"],
        ["name" => "Erro de Processo (Paciente deixa de realizar exames e/ou cirurgia)"],
        ["name" => "Falha na Administração de Dietas (Administrada diferente do prescrito, contaminada)"],
        ["name" => "Falha na Identificação do Paciente"],
        ["name" => "Flebite"],
        ["name" => "Fuga do paciente"],
        ["name" => "Hidratação não administrada"],
        ["name" => "Infecção hospitalar"],
        ["name" => "Morte inesperada"],
        ["name" => "Óbito intra-operatório ou pós-hoperatório imediato (paciente eletivos ou com baixo risco cirúrgico"],
        ["name" => "PCR inesperado"],
        ["name" => "Procedimento cirúrgico no lado errado do corpo"],
        ["name" => "Procedimento cirúrgico no paciente errado"],
        ["name" => "Queda"],
        ["name" => "Queixa técnica (Produto/Medicação)"],
        ["name" => "Reação medicamentosa"],
        ["name" => "Reação transfuncional ou imediatamente após transfusão de hemecomponentes"],
        ["name" => "Rótulo mal preenchido, incompleto ou incorreto"],
        ["name" => "Outros"],
    ];
    
    foreach ($events as $event) {
        $event = new Event($event['name']);
        $model->doInsert($event);
    }
    echo "Events Inserted\n";
} else {
    echo "Events was ignored\n";
}