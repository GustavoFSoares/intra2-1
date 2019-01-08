<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/eletronic-document/status', function() {
        $this->get('[/{params:.*}]', "HospitalApi\Controller\EletronicDocumentStatusController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\EletronicDocumentStatusController:insert", function(Request $req, Response $res, array $args) { });
        
        $this->put('/{id}', "HospitalApi\Controller\EletronicDocumentStatusController:update", function(Request $req, Response $res, array $args) { });
        
        $this->delete('/{id}', "HospitalApi\Controller\EletronicDocumentStatusController:delete", function(Request $req, Response $res, array $args) { });
});

$app->group('/eletronic-document/type', function() {
        $this->get('[/{params:.*}]', "HospitalApi\Controller\EletronicDocumentTypeController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\EletronicDocumentTypeController:insert", function(Request $req, Response $res, array $args) { });
        
        $this->put('/{id}', "HospitalApi\Controller\EletronicDocumentTypeController:update", function(Request $req, Response $res, array $args) { });
        
        $this->delete('/{id}', "HospitalApi\Controller\EletronicDocumentTypeController:delete", function(Request $req, Response $res, array $args) { });
});

$app->group('/eletronic-document', function() {
        $this->get('[/{params:.*}]', "HospitalApi\Controller\EletronicDocumentController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\EletronicDocumentController:insert", function(Request $req, Response $res, array $args) { });

        $this->put('/{id}', "HospitalApi\Controller\EletronicDocumentController:update", function(Request $req, Response $res, array $args) { });
        
        $this->delete('/{id}', "HospitalApi\Controller\EletronicDocumentController:delete", function(Request $req, Response $res, array $args) { });
}); 