<?php

use HospitalApi\Entity\StatusMessage;
use HospitalApi\Model\StatusMessageModel;

$model = new StatusMessageModel();
echo "Atualizando Mensagem de Status\n";

    $statusMessages = [
        ['id' => 'user_incorrect', 'status' => false, 'message'=> 'Usuário ou Senha incorretos.', 'type' => 'danger'],        
        ['id' => 'user_inactive', 'status' => false, 'message' => 'Seu Usuário foi inativado, por favor contate a TI', 'type' => 'warning'],
        ['id' => 'group_not_found', 'status' => false, 'message' => 'Você não possui grupo cadastrado. Contate a TI', 'type' => 'warning'],
        ['id' => 'training_add', 'status' => true, 'message' => 'Adicionado ao treinamento', 'type' => 'success'],
        ['id' => 'in_training', 'status' => false, 'message' => 'Já cadastrado nesse treinamento', 'type' => 'warning'],
    ];
    
    foreach ($statusMessages as $statusMessage) {
        if(!$model->getRepository()->findById($statusMessage['id'])){
            $StatusMessage = new StatusMessage();
            $StatusMessage
                ->setId($statusMessage['id'])
                ->setstatus($statusMessage['status'])
                ->setMessage($statusMessage['message'])
                ->setType($statusMessage['type']);
            $model->doInsert($StatusMessage);

            echo "      Mensagem de Status ".$statusMessage['id']." INSERTED\n";
        } else {
            echo "      Mensagem de Status ".$statusMessage['id']." ignored\n";
        }

    }