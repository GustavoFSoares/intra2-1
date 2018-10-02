<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/user', function () {

    $this->get('/users-admin-email/', "HospitalApi\Controller\UserController:getUsersAdminAction", function (Request $req, Response $res, array $args) { });
    $this->get('[/{params:.*}]', "HospitalApi\Controller\UserController:get", function (Request $req, Response $res, array $args) { });

    $this->post('/', "HospitalApi\Controller\UserController:insert", function (Request $req, Response $res, array $args) { });
    
    $this->put('/{id}', "HospitalApi\Controller\UserController:update", function (Request $req, Response $res, array $args) { });
    $this->put('/', "HospitalApi\Controller\UserController:updateUsers", function (Request $req, Response $res, array $args) { });
    
    $this->delete('/{id}', "HospitalApi\Controller\UserController:delete", function (Request $req, Response $res, array $args) { });
});