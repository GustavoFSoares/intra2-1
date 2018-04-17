<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\EmailModel;
use PHPMailer\PHPMailer\Exception;

class EmailController extends ControllerAbstract
{

    public function __construct() {
        parent::__construct(new EmailModel());
    }

    public function buildMailAction($req, $res) {
        $values = $req->getParsedBody();
        
        $this->writeMail($values['subject'], $values['body']);

        $this->model->setSender($values['sender']);
        $this->model->setReceiver($values['receiver']);

        return $res->withJson($this->model->send());
    }

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