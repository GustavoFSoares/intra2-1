<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

require 'Routes/link.php';
require 'Routes/email.php';
require 'Routes/adverseEvents.php';
require 'Routes/enterprise.php';
require 'Routes/event.php';
require 'Routes/sector.php';

$app->get('/script/insert', function(Request $req, Response $res, array $args){
        require __DIR__ . "/HospitalApi/Scripts/BossSector.php";
        require __DIR__ . "/HospitalApi/Scripts/Enterprise.php";
        require __DIR__ . "/HospitalApi/Scripts/Event.php";
        require __DIR__ . "/HospitalApi/Scripts/link.php";
        require __DIR__ . "/HospitalApi/Scripts/Sector.php";
});