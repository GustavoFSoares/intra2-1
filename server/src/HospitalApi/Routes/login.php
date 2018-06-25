<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

/**
 * @api @group
 * <b>Rotas de Login</b>
 * Grupo de Rotas relacionadas a Alertas
 * Indentificadas pelo caminho <i>/alert</i>
 */
$app->group('/login', function () {

    /**
     * <i>Cadastro de Alerta</i>
     * Recebe os dados de um alerta via POST e cria um novo registro
     * @link /alert/
     * @param POST $Alert
     * @return Boolean Status
     */
    $this->post('/', "HospitalApi\Controller\LoginController:auth", function (Request $req, Response $res, array $args) { });

});