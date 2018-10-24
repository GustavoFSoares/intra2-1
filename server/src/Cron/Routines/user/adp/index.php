<?php
    require __DIR__."/../../index.php";
    $GroupController = new \Cron\Controller\UserController();
    $GroupController->integrateWithAdpFileAction();