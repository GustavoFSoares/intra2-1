<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/file', function() {

    $this->get('/commissions/{fileName:.*}', "HospitalApi\Controller\FileController:getOrganogramAction", function(Request $req, Response $res, array $args) { });
    $this->get('/pops/', "HospitalApi\Controller\FileController:getPopsAction", function(Request $req, Response $res, array $args) { });
    $this->get('/archives/', "HospitalApi\Controller\FileController:getArchivesAction", function(Request $req, Response $res, array $args) { });
    $this->get('/comissions/', "HospitalApi\Controller\FileController:getComissionsAction", function(Request $req, Response $res, array $args) { });
    $this->get('/check-exist/{partialPath:.*}', "HospitalApi\Controller\FileController:checkFileExistAction", function(Request $req, Response $res, array $args) { });
    $this->get('/{filePath:.*}', "HospitalApi\Controller\FileController:getFileAction", function(Request $req, Response $res, array $args) { });
});