<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/cron/group', function () {

    $this->get('/insert', "Cron\Controller\GroupController:insert", function (Request $req, Response $res, array $args) { });
    $this->get('/update', "Cron\Controller\GroupController:update", function (Request $req, Response $res, array $args) { });
});