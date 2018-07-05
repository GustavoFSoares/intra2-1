<?php
    require __DIR__ . '/../../../vendor/autoload.php';
    require __DIR__ . '/../../middleware.php';
    session_start();

    $GroupController = new \Cron\Controller\GroupController();
    $GroupController->update();