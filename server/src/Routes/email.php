<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/mail', function() {
    $this->post('/send', "HospitalApi\Controller\EmailController:buildMailAction", function(Request $req, Response $res, array $args) {
    
});

});