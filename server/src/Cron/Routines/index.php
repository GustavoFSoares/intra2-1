<?php
require __DIR__ . '/../../../vendor/autoload.php';
require __DIR__ . '/../../../src/middleware.php';
$settings = require __DIR__ . '/../../../src/settings.php';

$app = new \Slim\App($settings);
new \HospitalApi\BasicApplicationAbstract($app);
session_start();