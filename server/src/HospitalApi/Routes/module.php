<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/module', function () {

    $this->get('/[{id}]', "HospitalApi\Controller\ModuleController:get", function (Request $req, Response $res, array $args) { });
    $this->get('/group/[{group}]', "HospitalApi\Controller\ModuleController:getModulesByGroup", function (Request $req, Response $res, array $args) { });

    $this->post('/', "HospitalApi\Controller\ModuleController:insert", function (Request $req, Response $res, array $args) { });
    $this->post('/chield/', "HospitalApi\Controller\ModuleController:insertChield", function (Request $req, Response $res, array $args) { });
    $this->post('/group/', "HospitalApi\Controller\ModuleController:updateGroups", function (Request $req, Response $res, array $args) { });
    
    $this->put('/{id}', "HospitalApi\Controller\ModuleController:update", function (Request $req, Response $res, array $args) { });
    $this->put('/chield/{id}', "HospitalApi\Controller\ModuleController:updateChield", function (Request $req, Response $res, array $args) { });
    $this->put('/change-status/{id}', "HospitalApi\Controller\ModuleController:changeStatusAction", function (Request $req, Response $res, array $args) { });
    
    $this->delete('/{id}', "HospitalApi\Controller\ModuleController:delete", function (Request $req, Response $res, array $args) { });
    $this->delete('/chield/{id}', "HospitalApi\Controller\ModuleController:removeChield", function (Request $req, Response $res, array $args) { });
});