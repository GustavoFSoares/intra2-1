<?php

use HospitalApi\Entity\EletronicDocumentType;
use HospitalApi\Model\EletronicDocumentTypeModel;

$model = new EletronicDocumentTypeModel();

if(!$model->findBy()){
    $eletronicDocumentTypes = [
        [ 'name' => 'Memorando', 'code' => 'MEMO' ],
        [ 'name' => 'Comunicação Interna', 'code' => 'COMU' ],
     ];
    
    foreach ($eletronicDocumentTypes as $type) {
        $EletronicDocumentType = new EletronicDocumentType();
        $EletronicDocumentType
            ->setName($type['name'])
            ->setCode($type['code']);
        $model->doInsert($EletronicDocumentType);
    }
    echo "eletronicDocumentType Inserted\n";
} else {
    echo "eletronicDocumentType was ignored\n";
}