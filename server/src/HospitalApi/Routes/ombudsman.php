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
        $this->get('/doc/reprint[/{id:.*}]', "HospitalApi\Controller\OmbudsmanController:reprintAction", function(Request $req, Response $res, array $args) { }); 
        $this->get('/waiting[/{params:.*}]', "HospitalApi\Controller\OmbudsmanController:getWaitingAction", function(Request $req, Response $res, array $args) { });
        $this->get('/permission/[params:.*]', "HospitalApi\Controller\OmbudsmanController:gotPermissionAction", function (Request $req, Response $res, array $args) { });
        $this->get('/messages/[/{params:.*}]', "HospitalApi\Controller\OmbudsmanController:getChatsByOmbudsmanAction", function (Request $req, Response $res, array $args) { });
        $this->get('[/{params:.*}]', "HospitalApi\Controller\OmbudsmanController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\OmbudsmanController:insert", function(Request $req, Response $res, array $args) { });
        $this->post('/messages/', "HospitalApi\Controller\OmbudsmanController:insertChatAction", function (Request $req, Response $res, array $args) { });
        $this->post('/file[/{params:.*}]', "HospitalApi\Controller\OmbudsmanController:uploadFileAction", function (Request $req, Response $res, array $args) { });

        $this->put('/{id}', "HospitalApi\Controller\OmbudsmanController:update", function(Request $req, Response $res, array $args) { });
        $this->put('/manager-response/{id}', "HospitalApi\Controller\OmbudsmanController:setManagerResponseAction", function(Request $req, Response $res, array $args) { });
        $this->put('/ombudsman-response/{id}', "HospitalApi\Controller\OmbudsmanController:setOmbudsmanResponseAction", function(Request $req, Response $res, array $args) { });
        $this->put('/add-manager/{id}/{type}', "HospitalApi\Controller\OmbudsmanController:addManagerAction", function(Request $req, Response $res, array $args) { });
        $this->put('/remove-manager/{id}/{type}', "HospitalApi\Controller\OmbudsmanController:removeManagerAction", function(Request $req, Response $res, array $args) { });
        $this->put('/close-chat/{id}', "HospitalApi\Controller\OmbudsmanController:closeChatAction", function(Request $req, Response $res, array $args) { });
        $this->put('/finish/{id}', "HospitalApi\Controller\OmbudsmanController:finishAction", function(Request $req, Response $res, array $args) { });

        $this->delete('/messages[/{params:.*}]', "HospitalApi\Controller\OmbudsmanController:cleanNotificationAction", function (Request $req, Response $res, array $args) { });
        $this->delete('/{id}', "HospitalApi\Controller\OmbudsmanController:delete", function(Request $req, Response $res, array $args) { });
}); 