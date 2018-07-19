<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/training', function () {

    $this->get('/type/[{id}]', "HospitalApi\Controller\TrainingTypeController:get", function (Request $req, Response $res, array $args) { });
    $this->get('/[{id}]', "HospitalApi\Controller\TrainingController:get", function (Request $req, Response $res, array $args) { });
    
    $this->post('/', "HospitalApi\Controller\TrainingController:insert", function (Request $req, Response $res, array $args) { });
    
    $this->put('/', "HospitalApi\Controller\TrainingController:update", function (Request $req, Response $res, array $args) { });
});