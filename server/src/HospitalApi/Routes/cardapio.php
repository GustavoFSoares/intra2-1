<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

$app->group('/cardapio', function () {
    $this->get('/menu/', "HospitalApi\Controller\CardapioController:getNextMeal", function (Request $req, Response $res, array $args) { });
    $this->get('/get/', "HospitalApi\Controller\CardapioController:getCardapios", function(Request $req, Response $res, array $args) { });

    $this->post('/', "HospitalApi\Controller\CardapioController:insert", function (Request $req, Response $res, array $args) { });

    $this->put('/{id}', "HospitalApi\Controller\CardapioController:update", function (Request $req, Response $res, array $args) { });

    $this->delete('/{id}', "HospitalApi\Controller\CardapioController:delete", function (Request $req, Response $res, array $args) { });
});