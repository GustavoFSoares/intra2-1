<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', 'http://localhost')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

require 'Routes/link.php';
require 'Routes/email.php';
require 'Routes/adverseEvents.php';
require 'Routes/enterprise.php';
require 'Routes/event.php';
require 'Routes/sector.php';

// Routes
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/script/insert/{file}', function(Request $req, Response $res, array $args){
    if(isset($args['file'])){
        $file = $args['file'].'.php';
        require __DIR__."/HospitalApi/Scripts/$file";
    } else {
        require __DIR__ . "/HospitalApi/Scripts/Event";
        require __DIR__ . "/HospitalApi/Scripts/Enterprise";
        require __DIR__ . "/HospitalApi/Scripts/link";
    }
    
});