<?php

use HospitalApi\Entity\EletronicDocumentStatus;
use HospitalApi\Model\EletronicDocumentStatusModel;

$model = new eletronicDocumentStatusModel();

if(!$model->findBy()){
    $eletronicDocumentStatus = [
        [ 'name' => 'Cadastrado', 'level' => 1 ],
        [ 'name' => 'Enviado', 'level' => 2 ],
        [ 'name' => 'Rascunho', 'level' => 0 ],
        [ 'name' => 'Análise', 'level' => 3 ],
        [ 'name' => 'Aguardando Validação', 'level' => 4 ],
        [ 'name' => 'Finalizado', 'level' => 5 ],
     ];
    
    foreach ($eletronicDocumentStatus as $status) {
        $EletronicDocumentStatus = new EletronicDocumentStatus();
        $EletronicDocumentStatus
            ->setName($status['name'])
            ->setLevel($status['level']);
        $model->doInsert($EletronicDocumentStatus);
    }
    echo "eletronicDocumentStatus Inserted\n";
} else {
    echo "eletronicDocumentStatus was ignored\n";
}