<?php

use HospitalApi\Entity\EletronicDocumentStatus;
use HospitalApi\Model\EletronicDocumentStatusModel;

$model = new eletronicDocumentStatusModel();

if(!$model->findBy()){
    $eletronicDocumentStatus = [
        [ 'id' => 'calceled',           'order' => 0, 'name' => 'Cancelado'],
        [ 'id' => 'draft',              'order' => 1, 'name' => 'Rascunho'],
        [ 'id' => 'send',               'order' => 2, 'name' => 'Enviado'],
        [ 'id' => 'waiting-signature',  'order' => 3, 'name' => 'Aguardado Validação'],
        [ 'id' => 'waiting-correction', 'order' => 4, 'name' => 'Aguardado Retificação'],
        [ 'id' => 'Revoked',            'order' => 5, 'name' => 'Revogado'],
        [ 'id' => 'finished',           'order' => 6, 'name' => 'Finalizado'],
        [ 'id' => 'filed',              'order' => 7, 'name' => 'Arquivado' ]
     ];
    
    foreach ($eletronicDocumentStatus as $status) {
        $EletronicDocumentStatus = new EletronicDocumentStatus();
        $EletronicDocumentStatus
            ->setId($status['id'])
            ->setName($status['name'])
            ->setOrder($status['order']);
        $model->doInsert($EletronicDocumentStatus);
    }
    echo "eletronicDocumentStatus Inserted\n";
} else {
    echo "eletronicDocumentStatus was ignored\n";
}