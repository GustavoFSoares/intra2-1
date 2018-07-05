<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/covenants', function () {

    $this->get('/[{id}]', "HospitalApi\Controller\CovenantsController:get", function (Request $req, Response $res, array $args) { });

    $this->post('/', "HospitalApi\Controller\CovenantsController:insert", function (Request $req, Response $res, array $args) { });
    
    $this->put('/{id}', "HospitalApi\Controller\CovenantsController:update", function (Request $req, Response $res, array $args) { });
    $this->put('/change-status/{id}', "HospitalApi\Controller\CovenantsController:changeStatus", function (Request $req, Response $res, array $args) { });
    
    $this->delete('/{id}', "HospitalApi\Controller\CovenantsController:delete", function (Request $req, Response $res, array $args) { });
});