<?php
use HospitalApi\Controller\Session;
date_default_timezone_set("America/Sao_Paulo");

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => true, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
    'session' => new Session(),
    'em' => \HospitalApi\Model\ModelAbstract::createEntityManager(),
];
