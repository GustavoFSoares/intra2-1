<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/ombudsman/demands', function() {
        $this->get('[/{params:.*}]', "HospitalApi\Controller\OmbudsmanDemandsController:get", function(Request $req, Response $res, array $args) { });
        
        $this->post('/', "HospitalApi\Controller\OmbudsmanDemandsController:insert", function(Request $req, Response $res, array $args) { });
        
        $this->put('/{id}', "HospitalApi\Controller\OmbudsmanDemandsController:update", function(Request $req, Response $res, array $args) { });
        
        $this->delete('/{id}', "HospitalApi\Controller\OmbudsmanDemandsController:delete", function(Request $req, Response $res, array $args) { });
});