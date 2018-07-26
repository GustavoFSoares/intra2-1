<?php
    require __DIR__ . '/../../../../vendor/autoload.php';
    require __DIR__ . '/../../../../src/middleware.php';
    session_start();
    
    $GroupController = new \Cron\Controller\UserController();
    $GroupController->update();