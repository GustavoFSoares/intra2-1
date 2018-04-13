<?php

use HospitalApi\Model\LinkModel;
use HospitalApi\Entity\Link;

$model = new LinkModel();

$links = [
    [
        "id" => "15" ,
        "url" => "https://www.adpweb.com.br/rhweb/" ,
        "title" => "ADP Web" ,
        "icon" => "/static/img/links/adp.jpg" ,
        "externalLink" => true
    ], [
        "id" => "8" ,
        "url" => "https://sistemas.canoas.rs.gov.br/rdweb/Pages/en-US/login.aspx" ,
        "title" => "AGHOS" ,
        "icon" => "/static/img/links/aghos.jpg" ,
        "externalLink" =>  true
    ], [
        "id" => "14" ,
        "url" => "/glpi/" ,
        "title" => "Chamados TI" ,
        "icon" => "/static/img/links/glpi.png" ,
        "externalLink" =>  true
    ], [
        "id" => "2" ,
        "url" => "http://www.datasus.gov.br/cid10/V2008/cid10.htm" ,
        "title" => "CID-10" ,
        "icon" => "/static/img/links/cid.jpg" ,
        "externalLink" =>  true
    ], [
        "id" => "11" ,
        "url" => "http://www.portalctn.com.br/novo/" ,
        "title" => "CTN" ,
        "icon" => "/static/img/links/ctn.png" ,
        "externalLink" =>  true
    ], [
        "id" => "4" ,
        "url" => "https://cadastro.saude.gov.br/cadsusweb/login.jsp" ,
        "title" => "DATASUS" ,
        "icon" => "/static/img/links/datasus.jpg" ,
        "externalLink" =>  true
    ], [
        "id" => "13" ,
        "url" => "https://portal.office.com/" ,
        "title" => "E-mail GAMP" ,
        "icon" => "/static/img/links/outlook.png" ,
        "externalLink" =>  true
    ], [
        "id" => "17" ,
        "url" => "/eventos-adversos/" ,
        "title" => "Evento Adverso" ,
        "icon" => "/static/img/links/qsp.jpg" ,
        "externalLink" =>  false
    ], [
        "id" => "9" ,
        "url" => "http://170.246.1.102/fast" ,
        "title" => "FAST" ,
        "icon" => "/static/img/links/fast.jpg" ,
        "externalLink" =>  true
    ], [
        "id" => "18" ,
        "url" => "https://gerint-hom.procempa.com.br" ,
        "title" => "Gerint" ,
        "icon" => "/static/img/links/gerint.jpg" ,
        "externalLink" =>  true
    ], [
        "id" => "12" ,
        "url" => "https://www3.ghc.com.br/paciente/defaulthu.aspx" ,
        "title" => "GHC" ,
        "icon" => "/static/img/links/ghc.jpg" ,
        "externalLink" =>  true
    ], [
        "id" => "1" ,
        "url" => "https://www.e-nfs.com.br/e-nfs_canoas/index.jsp" ,
        "title" => "NFE Canoas" ,
        "icon" => "/static/img/links/nfe.gif" ,
        "externalLink" =>  true
    ], [
        "id" => "10" ,
        "url" => "http://rlfisioterapia.com.br/" ,
        "title" => "RL FISIO" ,
        "icon" => "/static/img/links/rlfisio.png" ,
        "externalLink" =>  true
    ], [
        "id" => "7" ,
        "url" => "http://sfar.org/" ,
        "title" => "SFAR" ,
        "icon" => "/static/img/links/sfar.jpg" ,
        "externalLink" =>  true
    ], [
        "id" => "16" ,
        "url" => "http://sistemas.canoas.rs.gov.br/sigss/login" ,
        "title" => "SIGSS" ,
        "icon" => "/static/img/links/sigss.jpg" ,
        "externalLink" =>  true
    ], [
        "id" => "5" ,
        "url" => "http://sigtap.datasus.gov.br/tabela-unificada/app/sec/inicio.jsp" ,
        "title" => "SIGTAP DATASUS" ,
        "icon" => "/static/img/links/sigtap.jpg" ,
        "externalLink" =>  true
    ], [
        "id" => "6" ,
        "url" => "https://secweb.procergs.com.br/vgs/soe/PRSoeLogon.jsp" ,
        "title" => "VGS" ,
        "icon" => "/static/img/links/vgs.jpg" ,
        "externalLink" =>  true
    ]
];

foreach ($links as $link) {
    $l = new Link();
    $l
        ->setUrl($link['url'])
        ->setTitle($link['title'])
        ->setIcon($link['icon'])
        ->setExternalLink($link['externalLink']);
    $model->insert($l);
}
