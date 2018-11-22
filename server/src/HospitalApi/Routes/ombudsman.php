<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/ombudsman/demands', function() {
        $this->get('[/{params:.*}]', "HospitalApi\Controller\OmbudsmanDemandsController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\OmbudsmanDemandsController:insert", function(Request $req, Response $res, array $args) { });
        
        $this->put('/{id}', "HospitalApi\Controller\OmbudsmanDemandsController:update", function(Request $req, Response $res, array $args) { });
        
        $this->delete('/{id}', "HospitalApi\Controller\OmbudsmanDemandsController:delete", function(Request $req, Response $res, array $args) { });
});

$app->group('/ombudsman/type', function() {
        $this->get('[/{params:.*}]', "HospitalApi\Controller\OmbudsmanTypeController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\OmbudsmanTypeController:insert", function(Request $req, Response $res, array $args) { });
        
        $this->put('/{id}', "HospitalApi\Controller\OmbudsmanTypeController:update", function(Request $req, Response $res, array $args) { });
        
        $this->delete('/{id}', "HospitalApi\Controller\OmbudsmanTypeController:delete", function(Request $req, Response $res, array $args) { });
});

$app->group('/ombudsman', function() {
        $this->get('/doc/[/{type}/{page}]', "HospitalApi\Controller\OmbudsmanController:printDocumentAction", function(Request $req, Response $res, array $args) { }); 
        $this->get('[/{params:.*}]', "HospitalApi\Controller\OmbudsmanController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\OmbudsmanController:insert", function(Request $req, Response $res, array $args) { });

        $this->put('/{id}', "HospitalApi\Controller\OmbudsmanController:update", function(Request $req, Response $res, array $args) { });

        $this->delete('/{id}', "HospitalApi\Controller\OmbudsmanController:delete", function(Request $req, Response $res, array $args) { });
});