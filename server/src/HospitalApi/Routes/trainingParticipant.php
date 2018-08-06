<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/training-participant', function () {

    $this->get('/{id}', "HospitalApi\Controller\TrainingParticipantController:getParticipantsByTraining", function (Request $req, Response $res, array $args) { });
    
    $this->put('/{id}', "HospitalApi\Controller\TrainingParticipantController:update", function (Request $req, Response $res, array $args) { });
    
});