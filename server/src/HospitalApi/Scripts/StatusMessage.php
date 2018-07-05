<?php

use HospitalApi\Entity\StatusMessage;
use HospitalApi\Model\StatusMessageModel;

$model = new StatusMessageModel();

if(!$model->findAll()){
    $StatusMessages = [
        ['id' => 'user_incorrect', 'status' => false, 'message'=> 'Usuário ou Senha incorretos.'],        
        ['id' => 'user_inactive', 'status' => false, 'message' => 'Seu Usuário foi inativado, por favor contate a TI'],
        ['id' => 'group_not_found', 'status' => false, 'message' => 'Você não possui grupo cadastrado. Contate a TI']
    ];
    
    foreach ($StatusMessages as $statusMessage) {
        $StatusMessage = new StatusMessage();
        $StatusMessage
            ->setId($statusMessage['id'])
            ->setstatus($statusMessage['status'])
            ->setMessage($statusMessage['message']);
        $model->doInsert($StatusMessage);
    }
    echo "StatusMessage Inserted<br>";
} else {
    echo "StatusMessage was ignored<br>";
}