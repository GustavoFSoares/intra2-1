<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/incident-reporting', function () {
    $this->get('/[{id}]', "HospitalApi\Controller\IncidentReportingController:get", function (Request $req, Response $res, array $args) { });
    $this->get('/messages/{id}', "HospitalApi\Controller\IncidentReportingController:getChatsByIncident", function (Request $req, Response $res, array $args) { });
    
    $this->post('/', "HospitalApi\Controller\IncidentReportingController:insert", function (Request $req, Response $res, array $args) { });
    $this->post('/messages/', "HospitalApi\Controller\IncidentReportingController:insertChat", function (Request $req, Response $res, array $args) { });
    
    $this->put('/{id}', "HospitalApi\Controller\IncidentReportingController:update", function (Request $req, Response $res, array $args) { });
    $this->put('/add-group/{id}', "HospitalApi\Controller\IncidentReportingController:insertGroupToTransitionList", function (Request $req, Response $res, array $args) { });
    $this->put('/remove-group/{id}', "HospitalApi\Controller\IncidentReportingController:removeGroupToTransitionList", function (Request $req, Response $res, array $args) { });
    
    $this->delete('/{id}', "HospitalApi\Controller\IncidentReportingController:delete", function (Request $req, Response $res, array $args) { });
});