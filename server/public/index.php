<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}



require __DIR__ . '/../vendor/autoload.php';

use HospitalApi\Entity\Email;
$e = new Email();

echo '<br><br>';
echo '!!!'.__FILE__.':<b>'.__LINE__.'</b>'.'!!!';
echo '<pre>';
print_r($e);
echo '</pre>';
die('');


session_start();

date_default_timezone_set('America/Sao_Paulo');

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';

$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();