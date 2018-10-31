<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/rotine', function() {

    $this->get('/available/', "HospitalApi\Controller\RotineController:getRotinesAvailableAction", function(Request $req, Response $res, array $args) { });
    $this->get('/logs/{id}', "HospitalApi\Controller\RotineController:getLogsAction", function(Request $req, Response $res, array $args) { });
    $this->get('[/{params:.*}]', "HospitalApi\Controller\RotineController:get", function(Request $req, Response $res, array $args) { });
    
    $this->post('/execute/', "HospitalApi\Controller\RotineController:executeAction", function(Request $req, Response $res, array $args) { });
});