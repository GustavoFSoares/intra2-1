<?php

use HospitalApi\Entity\StatusMessage;
use HospitalApi\Model\StatusMessageModel;

$model = new StatusMessageModel();

if(!$model->findAll()){
    $StatusMessages = [
        ['id' => 'user_incorrect', 'status' => false, 'message'=> 'Usuário ou Senha incorretos.', 'type' => 'danger'],        
        ['id' => 'user_inactive', 'status' => false, 'message' => 'Seu Usuário foi inativado, por favor contate a TI', 'type' => 'warning'],
        ['id' => 'group_not_found', 'status' => false, 'message' => 'Você não possui grupo cadastrado. Contate a TI', 'type' => 'warning'],
        ['id' => 'training_add', 'status' => true, 'message' => 'Adicionado ao treinamento', 'type' => 'success'],
        ['id' => 'in_training', 'status' => false, 'message' => 'Já cadastrado nesse treinamento', 'type' => 'warning'],
    ];
    
    foreach ($StatusMessages as $statusMessage) {
        $StatusMessage = new StatusMessage();
        $StatusMessage
            ->setId($statusMessage['id'])
            ->setstatus($statusMessage['status'])
            ->setMessage($statusMessage['message'])
            ->setType($statusMessage['type']);
        $model->doInsert($StatusMessage);
    }
    echo "StatusMessage Inserted\n";
} else {
    echo "StatusMessage was ignored\n";
}