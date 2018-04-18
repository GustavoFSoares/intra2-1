<?php

use HospitalApi\Model\LinkModel;
use HospitalApi\Entity\Link;

$model = new LinkModel();

$links = [
    [
        "url" => "https://www.adpweb.com.br/rhweb/" ,
        "title" => "ADP Web" ,
        "icon" => "/static/img/links/adp.jpg" ,
        "externalLink" => true
    ], [
        "url" => "https://sistemas.canoas.rs.gov.br/rdweb/Pages/en-US/login.aspx" ,
        "title" => "AGHOS" ,
        "icon" => "/static/img/links/aghos.jpg" ,
        "externalLink" =>  true
    ], [
        "url" => "/glpi/" ,
        "title" => "Chamados TI" ,
        "icon" => "/static/img/links/glpi.png" ,
        "externalLink" =>  true
    ], [
        "url" => "http://www.datasus.gov.br/cid10/V2008/cid10.htm" ,
        "title" => "CID-10" ,
        "icon" => "/static/img/links/cid.jpg" ,
        "externalLink" =>  true
    ], [
        "url" => "http://www.portalctn.com.br/novo/" ,
        "title" => "CTN" ,
        "icon" => "/static/img/links/ctn.png" ,
        "externalLink" =>  true
    ], [
        "url" => "https://cadastro.saude.gov.br/cadsusweb/login.jsp" ,
        "title" => "DATASUS" ,
        "icon" => "/static/img/links/datasus.jpg" ,
        "externalLink" =>  true
    ], [
        "url" => "https://portal.office.com/" ,
        "title" => "E-mail GAMP" ,
        "icon" => "/static/img/links/outlook.png" ,
        "externalLink" =>  true
    ], [
        "url" => "/eventos-adversos/" ,
        "title" => "Evento Adverso" ,
        "icon" => "/static/img/links/qsp.jpg" ,
        "externalLink" =>  false
    ], [
        "url" => "http://170.246.1.102/fast" ,
        "title" => "FAST" ,
        "icon" => "/static/img/links/fast.jpg" ,
        "externalLink" =>  true
    ], [
        "url" => "https://gerint-hom.procempa.com.br" ,
        "title" => "Gerint" ,
        "icon" => "/static/img/links/gerint.jpg" ,
        "externalLink" =>  true
    ], [
        "url" => "https://www3.ghc.com.br/paciente/defaulthu.aspx" ,
        "title" => "GHC" ,
        "icon" => "/static/img/links/ghc.jpg" ,
        "externalLink" =>  true
    ], [
        "url" => "https://www.e-nfs.com.br/e-nfs_canoas/index.jsp" ,
        "title" => "NFE Canoas" ,
        "icon" => "/static/img/links/nfe.gif" ,
        "externalLink" =>  true
    ], [
        "url" => "http://rlfisioterapia.com.br/" ,
        "title" => "RL FISIO" ,
        "icon" => "/static/img/links/rlfisio.png" ,
        "externalLink" =>  true
    ], [
        "url" => "http://sfar.org/" ,
        "title" => "SFAR" ,
        "icon" => "/static/img/links/sfar.jpg" ,
        "externalLink" =>  true
    ], [
        "url" => "http://sistemas.canoas.rs.gov.br/sigss/login" ,
        "title" => "SIGSS" ,
        "icon" => "/static/img/links/sigss.jpg" ,
        "externalLink" =>  true
    ], [
        "url" => "http://sigtap.datasus.gov.br/tabela-unificada/app/sec/inicio.jsp" ,
        "title" => "SIGTAP DATASUS" ,
        "icon" => "/static/img/links/sigtap.jpg" ,
        "externalLink" =>  true
    ], [
        "url" => "https://secweb.procergs.com.br/vgs/soe/PRSoeLogon.jsp" ,
        "title" => "VGS" ,
        "icon" => "/static/img/links/vgs.jpg" ,
        "externalLink" =>  true
    ], [
        "url" => "https://examesonline.unimedpoa.com.br",
        "title" => "Unimed - Exames",
        "icon" => "/static/img/links/unimed.jpg",
        "externalLink" => true
    ],
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
