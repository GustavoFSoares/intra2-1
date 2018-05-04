<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Driver\PDOException;

/**
 * @api @group
 * <b>Rotas de Emails</b>
 * Grupo de Rotas relacionadas a email
 * Indentificadas pelo caminho <i>/mail</i>
 */
$app->group('/adverse-events', function () {

    /** 
     * <i>Enviar Email</i>
     * Recebe o POST com os atributos do Email 
     * que encaminha para <i>EmailController</i> onde
     * será construido o Email
     * @example Exemplo de Objeto de Email Esperado:
     * sender: {
     *     "mail": "email@gampcanoas.com.br",
     *     "name": "Nome Usuario",
     *     "password": "senhaEmail"
     * },
     * receiver: "email@gampcanoas.com.br",
     * body: "Corpo do Email em HTML", 
     * subject: "Assunto do Email",
     * cc: [
     *     "":"Lista de Emails a serem enviados em Cópia"
     * ]
     */
    $this->post('/save', "HospitalApi\Controller\AdverseEventsController:saveAction", function (Request $req, Response $res, array $args) { });

});