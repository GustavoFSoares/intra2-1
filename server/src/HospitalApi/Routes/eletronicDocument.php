<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/eletronic-documents/status', function() {
        $this->get('[/{params:.*}]', "HospitalApi\Controller\EletronicDocumentStatusController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\EletronicDocumentStatusController:insert", function(Request $req, Response $res, array $args) { });
        
        $this->put('/{id}', "HospitalApi\Controller\EletronicDocumentStatusController:update", function(Request $req, Response $res, array $args) { });
        
        $this->delete('/{id}', "HospitalApi\Controller\EletronicDocumentStatusController:delete", function(Request $req, Response $res, array $args) { });
});

$app->group('/eletronic-documents/type', function() {
        $this->get('[/{params:.*}]', "HospitalApi\Controller\EletronicDocumentTypeController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\EletronicDocumentTypeController:insert", function(Request $req, Response $res, array $args) { });
        
        $this->put('/{id}', "HospitalApi\Controller\EletronicDocumentTypeController:update", function(Request $req, Response $res, array $args) { });
        
        $this->delete('/{id}', "HospitalApi\Controller\EletronicDocumentTypeController:delete", function(Request $req, Response $res, array $args) { });
});

$app->group('/eletronic-documents/signature', function() {
        $this->get('/users-signed/{document-id}', "HospitalApi\Controller\EletronicDocumentSignatureController:getUserSignedAction", function(Request $req, Response $res, array $args) { });
        $this->get('/next-signature/{document-id}', "HospitalApi\Controller\EletronicDocumentSignatureController:getNextUserToSignAction", function(Request $req, Response $res, array $args) { });
        
        // $this->post('/', "HospitalApi\Controller\EletronicDocumentSignatureController:insert", function(Request $req, Response $res, array $args) { });
        
        // $this->put('/{id}', "HospitalApi\Controller\EletronicDocumentSignatureController:update", function(Request $req, Response $res, array $args) { });
        
        // $this->delete('/{id}', "HospitalApi\Controller\EletronicDocumentSignatureController:delete", function(Request $req, Response $res, array $args) { });
});

$app->group('/eletronic-documents', function() {
        $this->get('/file/[{id}/{prefix}]', "HospitalApi\Controller\EletronicDocumentController:getFileByPrefixAction", function(Request $req, Response $res, array $args) { });
        $this->get('/print-document/{id}', "HospitalApi\Controller\EletronicDocumentController:printDocumentAction", function(Request $req, Response $res, array $args) { });
        $this->get('[/{params:.*}]', "HospitalApi\Controller\EletronicDocumentController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\EletronicDocumentController:insert", function(Request $req, Response $res, array $args) { });
        $this->post('/file/[{prefix}/{name}]', "HospitalApi\Controller\EletronicDocumentController:uploadFileAction", function (Request $req, Response $res, array $args) { });
        
        $this->put('/{id}', "HospitalApi\Controller\EletronicDocumentController:update", function(Request $req, Response $res, array $args) { });
        $this->put('/set-like-canceled/{document-id}', "HospitalApi\Controller\EletronicDocumentController:setLikeCanceledAction", function(Request $req, Response $res, array $args) { });
        $this->put('/set-like-archived/{document-id}', "HospitalApi\Controller\EletronicDocumentController:setLikeArchivedAction", function(Request $req, Response $res, array $args) { });
        $this->put('/set-like-waiting/{document-id}/{user_id}', "HospitalApi\Controller\EletronicDocumentController:setLikeWaitingSignatureAction", function(Request $req, Response $res, array $args) { });
        $this->put('/sign/{type}/{id}', "HospitalApi\Controller\EletronicDocumentController:signDocumentAction", function(Request $req, Response $res, array $args) { });
        $this->put('/amendment-update/{id}/{user_id}', "HospitalApi\Controller\EletronicDocumentController:updateAmendmentAction", function(Request $req, Response $res, array $args) { });
        
        
        $this->delete('/{id}', "HospitalApi\Controller\EletronicDocumentController:delete", function(Request $req, Response $res, array $args) { });
}); 