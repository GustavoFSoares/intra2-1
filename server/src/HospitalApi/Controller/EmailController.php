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

        $model = $this->getModel();
        
        $model->configureMail($values['sender']['host']);
        $this->writeMail($model, $values['subject'], $values['body']);
        
        $model->buildLog($values);
        
        $model->setSender($values['sender']);
        $model->setReceiver($values['receiver']);

        return $res->withJson($model->send());
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
    public function writeMail(EmailModel $model, $subject = "Assunto", $body = "Texto") {
        $model->writeMail($subject, $body);
    }

}