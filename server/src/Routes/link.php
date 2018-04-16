<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/link', function()
{
    $this->get('/[{id}]', "HospitalApi\Controller\LinkController:get", function(Request $req, Response $res, array $args) { });
    
});