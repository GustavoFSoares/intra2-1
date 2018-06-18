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

$path = __dir__ . '/Routes';
$dir = dir($path);
while ($file = $dir->read()) {
    if($file != '.' && $file != '..'){
        require "$path/$file";
    }
}

$app->get('/script/insert', function(Request $req, Response $res, array $args){
        require __DIR__ . "/HospitalApi/Scripts/index.php";
});

$app->get('/insert/{file}', function (Request $req, Response $res, array $args) {
        if (isset($args['file'])) {
                $file = $args['file'];
                require __DIR__ . "/HospitalApi/Scripts/$file.php";
        }
});