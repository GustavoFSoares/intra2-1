<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/group', function () {

    $this->get('/[{id}]', "HospitalApi\Controller\GroupController:get", function (Request $req, Response $res, array $args) { });
});