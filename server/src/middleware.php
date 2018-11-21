<?php
use Symfony\Component\Yaml\Yaml;

// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
define('PATH', __DIR__);
define('DOCS', __DIR__."/../../../docs/");
define('FILES', __DIR__."/../files/");

loadConfigurations();

function loadConfigurations() {
    $file = getFileConfig();

    $file = file_get_contents("$file/configuration.yml");
    $yaml = Yaml::parse($file);

    switch (getUser()) {
        case 'dev':
            $yaml = $yaml['DEVELOPER'];
            break;

        case 'homo':
            $yaml = $yaml['HOMOLOG'];
            break;

        case 'prod':
            $yaml = $yaml['PRODUCTION'];
            break;

        case 'win':
            $yaml = $yaml['DEVWIN'];
            break;

        default:
            die('User on .env not found');
            break;
    }

    foreach ($yaml as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $key => $value) {
                define($key, $value);
            }
        } else {
            define($key, $value);
        }
    }

}

function getFileConfig(){
    return __DIR__ . "/../../config";
}

function getUser(){
    $file = getFileConfig();
    $user = file("$file/.env");
    return $user[0];
}