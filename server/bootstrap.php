<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";
require __DIR__ . '/src/middleware.php';

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/HospitalApi/Entity"), $isDevMode);

// or if you prefer XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config"), $isDevMode);
// database configuration parameters

$connectionOptions = [
    'dbname' => DATABASE_NAME,
    'user' => BOOTSTRAP['DB_USER'],
    'password' => BOOTSTRAP['DB_PASSWORD'],
    'host' => BOOTSTRAP['DB_HOST'],
    'driver' => BOOTSTRAP['DB_DRIVER']
];

// obtaining the entity manager
$entityManager = EntityManager::create($connectionOptions, $config);