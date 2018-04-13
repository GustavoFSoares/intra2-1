<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

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

$app->get('/links', function(Request $req, Response $res, array $args) {
    $this->logger->info("Get all links");

    $res = $res->withHeader('Content-Type', 'application/json');
    $res = $res->withHeader('Access-Control-Allow-Origin', '*');
    $res = $res->withHeader('Access-Control-Allow-Methods', '*');
    $res = $res->withHeader('Access-Control-Allow-Headers', '*');
    
    $res->getBody()->write(json_encode(['links' => true]));
    return $res;
});
