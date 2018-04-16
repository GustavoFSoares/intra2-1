<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

// Routes
// $app->get('/', HospitalApi\Controller\RoutesController::class);
// $app->get('/', HospitalApi\Controller\RoutesController::class. ':add');


$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/link/{id}', function(Request $req, Response $res, array $args) {
    $id = $args['id'];
    $this->logger->info("Get link by id: $id");

    $res->getBody()->write(json_encode(['links' => true]));

    return $res;
});

// $app->get('/links', function(Request $req, Response $res, array $args) {
//     $this->logger->info("Get all links");

//     return $res->withJson(['links' => true]);
// });
