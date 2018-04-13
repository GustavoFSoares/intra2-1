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

use HospitalApi\Entity\Usuario;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require __DIR__ . '/../vendor/autoload.php';
session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';

$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

//Passo 2 - Configuração
    $path = [
        'HospitalApi/Entity'
    ];
    $devMode = true;

    $config = Setup::createAnnotationMetadataConfiguration($path, $devMode);

    $connectionOptions = [
        'dbname' => 'hospital_api',
        'user' => 'root',
        'password' => 'root',
        'host' => 'mysql',
        'driver' => 'pdo_mysql',
        // 'path' => __DIR__ . 'db.sqlite',
    ];

    //Passo 3 - Objeto de persistencia
    $entityManager = EntityManager::create($connectionOptions, $config);

    // $entityManager
    //     ->getConnection()
    //     ->getConfiguration()
	// 	->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
		
	$u = new Usuario();
    $u->setEmail('jp@gmail.com');
    // INSERT
	$entityManager->persist($u);
	$entityManager->flush();

// Run app
$app->run();