<?php

use HospitalApi\Entity\UserType;
use HospitalApi\Model\UserTypeModel;

$model = new UserTypeModel();
echo "Atualizando Mensagem de Status\n";

    $userTypes = [
        [ 'id'=>'trainee',    'name'=>'Estagiário' ],
        [ 'id'=>'resident',   'name'=>'Residente'  ],
        [ 'id'=>'outsourced', 'name'=>'Terceiro'   ],
        [ 'id'=>'another',    'name'=>'Outros'     ],
    ];
    
    foreach ($userTypes as $userType) {
        if(!$model->getRepository()->findById($userType['id'])){
            $UserType = new UserType();
            $UserType
                ->setId($userType['id'])
                ->setName($userType['name']);
            $model->doInsert($UserType);

            echo "      Mensagem de Status ".$userType['id']." INSERTED\n";
        } else {
            echo "      Mensagem de Status ".$userType['id']." ignored\n";
        }

    }