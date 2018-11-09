<?php
    require __DIR__."/../../index.php";
    $UserController = new \Cron\Controller\UserController();
    try {
        $UserController->adpIntegration();
    } catch(\Exception $e) {
        echo \Helper\LoggerHelper::writeFile("=====================================================");
        echo \Helper\LoggerHelper::writeFile("ERRO - {$e->getMessage()}\n");
    }