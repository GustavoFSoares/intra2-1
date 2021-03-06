<?php 
namespace HospitalApi\Model;

use HospitalApi\Entity\Email;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * <b>EmailModel</b>
 * Classe responsável pela estruturação do Email
 * como também realizar o envio do mesmo
 */
class EmailModel extends ModelAbstract
{

    public $entity;
    private $_report;
    private $_mail;

    public function __construct($report) {
        $this->entity = new Email();
        $this->_report = $report;
        parent::__construct();
        
        $this->_mail = new PHPMailer(true);                          // Passing `true` enables exceptions
    }

    /**
     * @method createEmail()
     * Monta as informações do Email. 
     * Inserindo no Objeto de Email o Assunto,
     * Remetente, Destinatário e Menságem Enviada
     * @return void
     */
    public function createEmail() {
        $this->configureEmail($this->_report->getSender()['host']);
        $this->setSender($this->_report->getSender());
        $this->setReceiver($this->_report->getReceiver());
        
        if($this->_report->getCopy()){
            $this->setCopy($this->_report->getCopy());
        }
        
        $this->writeMail();
        $this->buildLog($this->_report);

        return $this;
    }

    /**
     * @method configureMail()
     * Método responsável por configurar a infraestrutura
     * do email, setando configurações de domínio, erros,
     * formato e tipo de conexão que será realizada
     * @return void
     */
    public function configureEmail($host) {
        //Server settings
        $this->_mail->isSMTP();                                      // Set mailer to use SMTP
        $this->_mail->SMTPDebug = false;                             // Enable verbose debug output
        $this->_mail->SMTPAuth = true;                               // Enable SMTP authentication
        $this->_mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $this->_mail->CharSet = 'UTF-8';                             // Specify main and backup SMTP servers
        $this->_mail->Host = "smtp.$host.com";                                // Specify main and backup SMTP servers
        $this->_mail->Port = 587;                                    // TCP port to connect to
        $this->_mail->IsHTML(true);                                  // Enable HTML
        $this->_mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ];
    }

    /**
     * @method setSender()
     * Recebe um Array contendo as informações do rementente,
     * contendo "email", "senha" e "nome", que será utilizado
     * para autenticação do usuário
     * @param Array $user
     * @return void
     */
    public function setSender($user) {
        $this->_mail->Username = $user['email'];                      // SMTP username
        $this->_mail->Password = $user['password'];                  // SMTP password
        $this->_mail->setFrom($user['email'], $user['name']);
    }

    /**
     * @method setReceiver()
     * Recebe uma String contendo o "email", para quem o email
     * será enviado
     * @param String $receiver
     * @return void
     */
    public function setReceiver($receiver) {
        //Recipients
        $this->_mail->addAddress($receiver);                         // Add a recipient
    }
    
    /**
     * @method setCopy()
     * Recebe um Array de chave padrão ([0]=>"email1", [1]=>"email2")
     * com a lista de emails para o qual o email deve ser enviado em cópia
     * @param Array $copys
     * @return void
     */
    public function setCopy($copys = []) {
        foreach ($copys as $copy) {
            $this->_mail->addCC($copy);
        }
    }

    /**
     * @method setAttachment()
     * Recebe uma String contendo o <i>caminho</i> para o arquivo
     * que irá ser enviado como anexo no email
     * @param String $attachmentFile
     * @return void
     */
    public function setAttachment($attachmentFile) {
        $this->_mail->addAttachment($attachmentFile);                // Add attachments
    }
    
    /**
     * @method writeMail()
     * Responsável por adicionar a mensagem ao corpo do email. 
     * Recebe o "Assunto" e uma String em formato de HTML contendo 
     * o "corpo" do email
     * @param String $subject
     * @param Html $body
     * @return void
     */
    public function writeMail() {
        $this->_mail->Subject = $this->_report->getSubject();
        $this->_mail->Body = $this->_report->getBody();
    }

    /**
     * @method send()
     * Envia o Emmail. Testa se o email conseguiu ser enviado
     * e retorna um Array ([status]=>Boolean) com situação de envio
     * <i>true</i> para enviado e <i>false</i> problemas de envio
     * @return Array[Boolean]
     */
    public function send() {
        try{
            $send = $this->_mail->send();
            if($send) {
                $this->createLog();

                return [ 'status' => true ];
            } else {
                return [ 'status' => 'err' ];
            }
        }catch(Exception $e){
            echo $e->getMEssage();
            return [ 'status' => false ];
        }
    }

    /**
     * @method buildLog()
     * Recebe as informações do POST e utiliza os valores
     * para "construir" um email, que será salvo no Banco de Dados
     * @param POST $mail
     * @return void
     */
    public function buildLog($mail){
        $this->entity
            ->setSender($mail->getSender()['email'])
            ->setReceiver($mail->getReceiver())
            ->setBody($mail->getBody());
    }

    /**
     * @method createLog()
     * Faz a inserção do Email no Banco de Dados para criar Log
     * @return void
     */
    public function createLog(){
        $this->doInsert($this->entity);
    }

    public function setReport($report){
        $this->_report = $report;

        return $this;
    }

}