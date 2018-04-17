<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\EmailModel;
use PHPMailer\PHPMailer\Exception;

/**
 * <b>EmailController</b>
 * Classe responsável por criar e enviar Email
 */
class EmailController extends ControllerAbstract
{

    public function __construct() {
        parent::__construct(new EmailModel());
    }

    /**
     * @method buildMailAction() 
     * O buildMailAction() é uma ação que  recebe
     * as informações via POST e encaminha montar
     * a estrutura do Email, adicionando remetente,
     * destinatários e corpo do email.
     * Ele retorna uma Status Boolean informando 
     * se email foi ou não enviado
     * 
     * @param [Request] $req
     * @param [Response] $res
     * @return boolean Status
     */
    public function buildMailAction($req, $res) {
        $values = $req->getParsedBody();
        
        $this->writeMail($values['subject'], $values['body']);

        $this->model->setSender($values['sender']);
        $this->model->setReceiver($values['receiver']);

        return $res->withJson($this->model->send());
    }

    /**
     * @method writeMail()
     * o writeMail() é responsável por montar
     * por montar o corpo do email, inserindo 
     * o Assunto e a Mensagem
     * 
     * @param string $subject
     * @param string $body
     * @return void
     */
    public function writeMail($subject = "Assunto", $body = "Texto") {
        $this->model->writeMail($subject, $body);
    }

}

/**
 * sender {
 *  "mail","name","password"
 * }
 * receiver(email)
 * body(html)
 * cc(email)
 * subject(string)
 * 
 */