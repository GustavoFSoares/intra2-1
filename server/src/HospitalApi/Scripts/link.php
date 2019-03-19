<?php

use HospitalApi\Model\LinkModel;
use HospitalApi\Entity\Link;

$model = new LinkModel();

    $links = [
        [
            "url" => "https://www.adpweb.com.br/rhweb/" ,
            "title" => "ADP Web" ,
            "icon" => "adp.jpg" ,
            "externalLink" => true
        ], [
            "url" => "https://sistemas.canoas.rs.gov.br/rdweb/Pages/en-US/login.aspx" ,
            "title" => "AGHOS" ,
            "icon" => "aghos.jpg" ,
            "externalLink" =>  true
        ], [
            "url" => "http://gamp-web/glpi/" ,
            "title" => "Chamados TI" ,
            "icon" => "glpi.png" ,
            "externalLink" =>  true
        ], [
            "url" => "http://www.datasus.gov.br/cid10/V2008/cid10.htm" ,
            "title" => "CID-10" ,
            "icon" => "cid.jpg" ,
            "externalLink" =>  true
        ], [
            "url" => "http://www.portalctn.com.br/novo/" ,
            "title" => "CTN" ,
            "icon" => "ctn.png" ,
            "externalLink" =>  true
        ], [
            "url" => "https://cadastro.saude.gov.br/cadsusweb/login.jsp" ,
            "title" => "DATASUS" ,
            "icon" => "datasus.jpg" ,
            "externalLink" =>  true
        ], [
            "url" => "https://dynamed.com",
            "title" => "DynaMed Plus",
            "icon" => "dynamed.jpg",
            "externalLink" => true
        ], [
            "url" => "https://portal.office.com/" ,
            "title" => "E-mail GAMP" ,
            "icon" => "outlook.png" ,
            "externalLink" =>  true
        ], [
            "url" => "/notificacao-de-incidentes/" ,
            "title" => "Notificação de Incidente" ,
            "icon" => "qsp.jpg" ,
            "externalLink" =>  false
        ], [
            "url" => "http://170.246.1.102/fast" ,
            "title" => "FAST" ,
            "icon" => "fast.jpg" ,
            "externalLink" =>  true
        ], [
            "url" => "https://gerint-hom.procempa.com.br" ,
            "title" => "Gerint" ,
            "icon" => "gerint.jpg" ,
            "externalLink" =>  true
        ], [
            "url" => "https://www3.ghc.com.br/paciente/defaulthu.aspx" ,
            "title" => "GHC" ,
            "icon" => "ghc.jpg" ,
            "externalLink" =>  true
        ], [
            "url" => "https://www.e-nfs.com.br/e-nfs_canoas/index.jsp" ,
            "title" => "NFE Canoas" ,
            "icon" => "nfe.gif" ,
            "externalLink" =>  true
        ], [
            "url" => "http://rlfisioterapia.com.br/" ,
            "title" => "RL FISIO" ,
            "icon" => "rlfisio.png" ,
            "externalLink" =>  true
        ], [
            "url" => "http://sfar.org/" ,
            "title" => "SFAR" ,
            "icon" => "sfar.jpg" ,
            "externalLink" =>  true
        ], [
            "url" => "http://sistemas.canoas.rs.gov.br/sigss/login" ,
            "title" => "SIGSS" ,
            "icon" => "sigss.jpg" ,
            "externalLink" =>  true
        ], [
            "url" => "http://sigtap.datasus.gov.br/tabela-unificada/app/sec/inicio.jsp" ,
            "title" => "SIGTAP DATASUS" ,
            "icon" => "sigtap.jpg" ,
            "externalLink" =>  true
        ], [
            "url" => "https://sso.online.tableau.com",
            "title" => "Tableau Online",
            "icon" => "tableau.jpg",
            "externalLink" => true
        ], [
            "url" => "https://examesonline.unimedpoa.com.br",
            "title" => "Unimed - Exames",
            "icon" => "unimed.jpg",
            "externalLink" => true
        ], [
            "url" => "https://secweb.procergs.com.br/vgs/soe/PRSoeLogon.jsp" ,
            "title" => "VGS" ,
            "icon" => "vgs.jpg" ,
            "externalLink" =>  true
        ], [
            "url" => "http://optixserver1/pacs/DS/studies.html" ,
            "title" => "Optix - HU" ,
            "icon" => "optix.jpg" ,
            "externalLink" =>  true
        ], [
            "url" => " http://optixserver2/pacs/DS/studies.html" ,
            "title" => "Optix - HPSC" ,
            "icon" => "optix.jpg" ,
            "externalLink" =>  true
        ], [
            "url" => " /usuario/documentos-eletronicos" ,
            "title" => "Documentos Eletrônicos" ,
            "icon" => "eletronic-documents.jpg" ,
            "externalLink" =>  false
        ],
    ];

    foreach ($links as $link) {
        $l = $model->getRepository()->findOneByUrl($link['url']);
        if(!$l) {
            $l = new Link();
            $l
                ->setUrl($link['url'])
                ->setTitle($link['title'])
                ->setIcon($link['icon'])
                ->setExternalLink($link['externalLink']);
            $model->doInsert($l);    
        
            echo "      Link {$link['title']} INSERTED\n";
        } else {
            $l
                ->setUrl($link['url'])
                ->setTitle($link['title'])
                ->setIcon($link['icon'])
                ->setExternalLink($link['externalLink']);
            $model->doUpdate($l);
            
            echo "      Link {$link['title']} UPDATED\n";
        }
        
        
    }