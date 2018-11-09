<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/duplicated-users', function () {

    $this->get('[/{params:.*}]', "HospitalApi\Controller\DuplicatedUsersController:get", function (Request $req, Response $res, array $args) { });
    
    $this->put('/check-duplicated/{id}', "HospitalApi\Controller\DuplicatedUsersController:checkDuplicationAction", function (Request $req, Response $res, array $args) { });
    
    $this->delete('/{id}', "HospitalApi\Controller\DuplicatedUsersController:delete", function (Request $req, Response $res, array $args) { });
});