<?php 
require_once __DIR__.'./../../../vendor/autoload.php';
require_once __DIR__.'./../../middleware.php';
$settings = require_once PATH . '/settings.php';

$app = new \Slim\App($settings);
new \HospitalApi\BasicApplicationAbstract($app);

$path = __dir__;
$dir = dir($path);

while ($file = $dir->read()) {
    if($file != '.' && $file != '..' && $file != "index.php"){
        require "$path/$file";
    }
}