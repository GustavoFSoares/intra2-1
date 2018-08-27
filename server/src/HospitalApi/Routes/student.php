<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/student', function () {

    $this->get('/[{id}]', "HospitalApi\Controller\StudentController:get", function (Request $req, Response $res, array $args) { });
    $this->get('/group/{group}', "HospitalApi\Controller\StudentController:getUsersByGroup", function (Request $req, Response $res, array $args) { });
    $this->get('/type/', "HospitalApi\Controller\StudentController:getEmployeeTypes", function (Request $req, Response $res, array $args) { });

    $this->post('/', "HospitalApi\Controller\StudentController:insert", function (Request $req, Response $res, array $args) { });
    
    $this->put('/{id}', "HospitalApi\Controller\StudentController:update", function (Request $req, Response $res, array $args) { });
    
    $this->delete('/{id}', "HospitalApi\Controller\StudentController:delete", function (Request $req, Response $res, array $args) { });
});