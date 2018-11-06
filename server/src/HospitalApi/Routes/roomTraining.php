<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/room-training', function() {

    $this->get('[/{params:.*}]', "HospitalApi\Controller\RoomTrainingController:get", function(Request $req, Response $res, array $args) { });
   
    $this->post('/', "HospitalApi\Controller\RoomTrainingController:insert", function(Request $req, Response $res, array $args) { });
   
    $this->put('/{id}', "HospitalApi\Controller\RoomTrainingController:update", function(Request $req, Response $res, array $args) { });
   
    $this->delete('/{id}', "HospitalApi\Controller\RoomTrainingController:delete", function(Request $req, Response $res, array $args) { });
    
});