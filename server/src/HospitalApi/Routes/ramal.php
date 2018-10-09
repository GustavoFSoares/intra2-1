<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

/**
 * @api @group
 * <b>Rotas de Ramais</b>
 * Grupo de Rotas relacionadas aos Ramais
 * Indentificadas pelo caminho <i>/ramal</i>
 */
$app->group('/ramal', function () {

    /**
     * <i>Getter para Ramais</i>
     * Recebe um Id(optionalmente) e retorna um objeto
     * com as Ramais cadastrados no Banco de Dados
     * @param Optional $id
     * @return Json Rotas 
     */
    $this->get('/[{id}]', "HospitalApi\Controller\RamalController:get", function (Request $req, Response $res, array $args) { });
    $this->get('/all/', "HospitalApi\Controller\RamalController:findAll", function (Request $req, Response $res, array $args) { });
    $this->get('/filter/{filter}', "HospitalApi\Controller\RamalController:filter", function (Request $req, Response $res, array $args) { });
    
    $this->post('/', "HospitalApi\Controller\RamalController:insert", function (Request $req, Response $res, array $args) { });
    $this->put('/{id}', "HospitalApi\Controller\RamalController:update", function (Request $req, Response $res, array $args) { });
    
    $this->delete('/{id}', "HospitalApi\Controller\RamalController:delete", function (Request $req, Response $res, array $args) { });
    $this->delete('/change-status/{id}', "HospitalApi\Controller\RamalController:changeStatusAction", function (Request $req, Response $res, array $args) { });
    
});