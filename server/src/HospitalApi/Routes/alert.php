<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

/**
 * @api @group
 * <b>Rotas de Alertas</b>
 * Grupo de Rotas relacionadas a Alertas
 * Indentificadas pelo caminho <i>/alert</i>
 */
$app->group('/alert', function () {

    /**
     * <i>Getter para Alertas</i>
     * Recebe um Id(optionalmente) e retorna um objeto
     * com os Alertas cadastrados no Banco de Dados
     * @link /alert/{id}
     * @param Optional $id
     * @return Json Alertas 
     */
    $this->get('/[{id}]', "HospitalApi\Controller\AlertController:get", function (Request $req, Response $res, array $args) { });
    
    /**
     * <i>Cadastro de Alerta</i>
     * Recebe os dados de um alerta via POST e cria um novo registro
     * @link /alert/
     * @param POST $Alert
     * @return Boolean Status
     */
    $this->post('/', "HospitalApi\Controller\AlertController:insert", function (Request $req, Response $res, array $args) { });

    /**
     * <i>Edição de Alerta</i>
     * Recebe os dados do Alerta via PUT e um atributo $id
     * Verifica se o registro existe e atualiza com as novas informações
     * @link /alert/{id}
     * @param PUT Alert
     * @param Integer $id
     * @return Boolean Status
     */
    $this->put('/{id}', "HospitalApi\Controller\AlertController:update", function (Request $req, Response $res, array $args) { });

    /**
     * <i>Exclusão de Alerta</i>
     * Recebe um atributo $id e exclui a linha referente no BD
     * @link /alert/{id}
     * @param Integer $id
     * @return Boolean Status
     */
    $this->delete('/{id}', "HospitalApi\Controller\AlertController:delete", function (Request $req, Response $res, array $args) { });

    /**
     * <i>Exclusão de Alerta</i>
     * Recebe um atributo $type e busca o último registo
     * cadastrado na Base de Dados daquele tipo e retorna
     * para Cliente
     * @link /alert/type/{type}
     * @param String $type
     * @return Json Alerta
     */
    $this->get('/type/{type}', "HospitalApi\Controller\AlertController:getByType", function (Request $req, Response $res, array $args) { });

});