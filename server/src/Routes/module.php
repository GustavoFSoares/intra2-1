<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/module', function () {

    $this->get('/[{id}]', "HospitalApi\Controller\ModuleController:get", function (Request $req, Response $res, array $args) { });
    $this->get('/group/[{group}]', "HospitalApi\Controller\ModuleController:getModulesByGroup", function (Request $req, Response $res, array $args) { });

    $this->post('/', "HospitalApi\Controller\ModuleController:insertGroup", function (Request $req, Response $res, array $args) { });
    
    $this->delete('/', "HospitalApi\Controller\ModuleController:deleteGroup", function (Request $req, Response $res, array $args) { });


});