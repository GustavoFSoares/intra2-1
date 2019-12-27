<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/incident-origin', function () {

    $this->get('/[{id}]', "HospitalApi\Controller\IncidentOriginController:get", function (Request $req, Response $res, array $args) { });
    $this->get('/enterprises/', "HospitalApi\Controller\IncidentOriginController:getEnterprises", function (Request $req, Response $res, array $args) { });
    $this->get('/enterprise/{enterprise}', "HospitalApi\Controller\IncidentOriginController:getOriginsByEnterprise", function (Request $req, Response $res, array $args) { });

    $this->post('/', "HospitalApi\Controller\IncidentOriginController:insert", function(Request $req, Response $res, array $args) { });

    $this->put('/{id}', "HospitalApi\Controller\IncidentOriginController:update", function(Request $req, Response $res, array $args) { });

    $this->delete('/{id}', "HospitalApi\Controller\IncidentOriginController:delete", function(Request $req, Response $res, array $args) { });
});