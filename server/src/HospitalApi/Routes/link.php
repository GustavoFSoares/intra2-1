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
$app->group('/link', function()
{

    /**
     * <i>Getter para Links</i>
     * Recebe um Id(optionalmente) e retorna um objeto
     * com as Links de Atalho cadastrados no Banco de Dados
     * @param Optional $id
     * @return Json Rotas 
     */
    $this->get('/all/[{id}]', "HospitalApi\Controller\LinkController:findAllAction", function(Request $req, Response $res, array $args) { });
    $this->get('/[{id}]', "HospitalApi\Controller\LinkController:get", function(Request $req, Response $res, array $args) { });
    
    $this->post('/', "HospitalApi\Controller\LinkController:insert", function(Request $req, Response $res, array $args) { });
    $this->post('/save-image[/{params:.*}]', "HospitalApi\Controller\LinkController:uploadFileAction", function(Request $req, Response $res, array $args) { });
    
    $this->put('/{id}', "HospitalApi\Controller\LinkController:update", function(Request $req, Response $res, array $args) { });
    $this->put('/change-status/{id}', "HospitalApi\Controller\LinkController:changeStatusAction", function (Request $req, Response $res, array $args) { });

    $this->delete('/{id}', "HospitalApi\Controller\LinkController:delete", function(Request $req, Response $res, array $args) { });
    
});