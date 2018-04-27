<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

/**
 * @api @group
 * <b>Rotas de Links</b>
 * Grupo de Rotas relacionadas a email
 * Indentificadas pelo caminho <i>/mail</i>
 */
$app->group('/sector', function () {

    /**
     * <i>Getter para Links</i>
     * Recebe um Id(optionalmente) e retorna um objeto
     * com as Links de Atalho cadastrados no Banco de Dados
     * @param Optional $id
     * @return Json Rotas 
     */
    $this->get('/[{id}]', "HospitalApi\Controller\SectorController:get", function (Request $req, Response $res, array $args) { });
    $this->get('/enterprise/{id}', "HospitalApi\Controller\SectorController:getSectorsByEnterpriseAction", function (Request $req, Response $res, array $args) { });
    
});