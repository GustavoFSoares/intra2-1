<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/cron/user', function () {

    $this->get('/update', "Cron\Controller\UserController:update", function (Request $req, Response $res, array $args) { });
});