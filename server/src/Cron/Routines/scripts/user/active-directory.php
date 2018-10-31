<?php
    require __DIR__."/../../index.php";
    $UserController = new \Cron\Controller\UserController();
    $UserController->update();