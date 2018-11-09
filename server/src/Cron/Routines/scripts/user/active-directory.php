<?php
    require __DIR__."/../../index.php";
    $UserController = new \Cron\Controller\UserController();
    try {
        $UserController->update();
    } catch(\Exception $e) {
        echo \Helper\LoggerHelper::writeFile("=====================================================");
        echo \Helper\LoggerHelper::writeFile("ERRO - {$e->getMessage()}\n");
    }