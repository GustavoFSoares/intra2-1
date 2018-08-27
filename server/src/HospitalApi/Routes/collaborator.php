<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/collaborator', function () {

    $this->get('/[{id}]', "HospitalApi\Controller\CollaboratorController:get", function (Request $req, Response $res, array $args) { });
    $this->get('/group/{group}', "HospitalApi\Controller\CollaboratorController:getUsersByGroup", function (Request $req, Response $res, array $args) { });
    $this->get('/type/', "HospitalApi\Controller\CollaboratorController:getEmployeeTypes", function (Request $req, Response $res, array $args) { });

    $this->post('/', "HospitalApi\Controller\CollaboratorController:insert", function (Request $req, Response $res, array $args) { });
    
    $this->put('/{id}', "HospitalApi\Controller\CollaboratorController:update", function (Request $req, Response $res, array $args) { });
    
    $this->delete('/{id}', "HospitalApi\Controller\CollaboratorController:delete", function (Request $req, Response $res, array $args) { });
});