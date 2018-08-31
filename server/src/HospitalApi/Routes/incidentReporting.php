<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/incident-reporting', function () {
    $this->get('/[{id}]', "HospitalApi\Controller\IncidentReportingController:get", function (Request $req, Response $res, array $args) { });
    
    $this->post('/', "HospitalApi\Controller\IncidentReportingController:insert", function (Request $req, Response $res, array $args) { });
    
    $this->put('/{id}', "HospitalApi\Controller\IncidentReportingController:update", function (Request $req, Response $res, array $args) { });
    
    $this->delete('/{id}', "HospitalApi\Controller\IncidentReportingController:delete", function (Request $req, Response $res, array $args) { });
});