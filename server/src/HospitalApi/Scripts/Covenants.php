<?php

use HospitalApi\Entity\Covenants;
use HospitalApi\Model\CovenantsModel;

$model = new CovenantsModel();

if (!$model->findBy()) {
    $Covenants = [
        ['title' => "Centro Clínico Gaúcho", 'link' => 'http://www.centroclinicogaucho.com.br'],
        ['title' => "Unimed Porto Alegre", 'link' => 'https://www.unimedpoa.com.br'],
        ['title' => "Agemed", 'link' => 'https://www.agemed.com.br'],
        ['title' => "Orizon", 'link' => 'https://www.orizonbrasil.com.br'],
        ['title' => "Cabergs", 'link' => 'https://www.cabergs.org.br'],
        ['title' => "Porto Alegre Clinicas", 'link' => 'http://www.portoalegreclinicas.com.br'],
    ];

    foreach ($Covenants as $Covenants) {
        $Covenant = new Covenants();
        
        $Covenant
            ->setTitle($Covenants['title'])
            ->setLink($Covenants['link']);
            
        $model->doInsert($Covenant);
    }
    echo "Covenants Inserted\n";
} else {
    echo "Covenants was ignored\n";
}