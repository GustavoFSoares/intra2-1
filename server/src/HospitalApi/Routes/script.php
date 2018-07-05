<?php 
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->get('/script/insert', function(Request $req, Response $res, array $args){
        require __DIR__ . "/../Scripts/index.php";
});

$app->get('/insert/{file}', function (Request $req, Response $res, array $args) {
        if (isset($args['file'])) {
                $file = $args['file'];
                require __DIR__ . "/Scripts/$file.php";
        }
});