<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/ombudsman/demands', function() {
        $this->get('[/{params:.*}]', "HospitalApi\Controller\OmbudsmanDemandsController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\OmbudsmanDemandsController:insert", function(Request $req, Response $res, array $args) { });
        
        $this->put('/{id}', "HospitalApi\Controller\OmbudsmanDemandsController:update", function(Request $req, Response $res, array $args) { });
        
        $this->delete('/{id}', "HospitalApi\Controller\OmbudsmanDemandsController:delete", function(Request $req, Response $res, array $args) { });
});

$app->group('/ombudsman/origin', function() {
        $this->get('[/{params:.*}]', "HospitalApi\Controller\OmbudsmanOriginController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\OmbudsmanOriginController:insert", function(Request $req, Response $res, array $args) { });
        
        $this->put('/{id}', "HospitalApi\Controller\OmbudsmanOriginController:update", function(Request $req, Response $res, array $args) { });
        
        $this->delete('/{id}', "HospitalApi\Controller\OmbudsmanOriginController:delete", function(Request $req, Response $res, array $args) { });
});

$app->group('/ombudsman', function() {
        $this->get('/doc/[/{origin}/{page}]', "HospitalApi\Controller\OmbudsmanController:printDocumentAction", function(Request $req, Response $res, array $args) { }); 
        $this->get('/waiting[/{params:.*}]', "HospitalApi\Controller\OmbudsmanController:getWaitingAction", function(Request $req, Response $res, array $args) { });
        $this->get('/permission/[params:.*]', "HospitalApi\Controller\OmbudsmanController:gotPermissionAction", function (Request $req, Response $res, array $args) { });
        $this->get('[/{params:.*}]', "HospitalApi\Controller\OmbudsmanController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\OmbudsmanController:insert", function(Request $req, Response $res, array $args) { });

        $this->put('/{id}', "HospitalApi\Controller\OmbudsmanController:update", function(Request $req, Response $res, array $args) { });
        $this->put('/response/{id}', "HospitalApi\Controller\OmbudsmanController:setResponseAction", function(Request $req, Response $res, array $args) { });

        $this->delete('/{id}', "HospitalApi\Controller\OmbudsmanController:delete", function(Request $req, Response $res, array $args) { });
}); 