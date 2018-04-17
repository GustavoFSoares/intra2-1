<?php 
namespace HospitalApi\Model;

use HospitalApi\Entity\Email;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailModel extends ModelAbstract
{

    public $entity;
    public $mail;

    public function __construct() {
        $this->entity = new Email();
        parent::__construct();
        
        $this->mail = new PHPMailer(true);                    // Passing `true` enables exceptions
        $this->configureMail();
    }

    public function configureMail(){
        //Server settings
        $this->mail->isSMTP();                                      // Set mailer to use SMTP
        $this->mail->SMTPDebug = true;                              // Enable verbose debug output
        $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
        $this->mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $this->mail->CharSet = 'UTF-8';                             // Specify main and backup SMTP servers
        $this->mail->Host = 'smtp.office365.com';                   // Specify main and backup SMTP servers
        $this->mail->Port = 587;                                    // TCP port to connect to
        $this->mail->IsHTML(true);                                  // Enable HTML
        $this->mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ];
    }

    public function setSender($user) {
        
        $this->mail->Username = $user['mail'];                      // SMTP username
        $this->mail->Password = $user['password'];                  // SMTP password
        $this->mail->setFrom($user['mail'], $user['name']);
    }

    public function setReceiver($receiver) {
        //Recipients
        $this->mail->addAddress($receiver);                         // Add a recipient
    }
    
    public function setCopy($copys = []) {
        foreach ($copys as $copy) {
            $this->mail->addCC($copy);
        }
    }
    
    public function setAttachment($attachmentFile) {
        $this->mail->addAttachment($attachmentFile);                // Add attachments
    }
    
    public function writeMail($subject, $body) {
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
    }

    public function send() {
        try{
            $send = $this->mail->send();
            if($send) {
                return [ 'status' => true ];
            } else {
                return [ 'status' => false ];
            }
        }catch(Exception $e){
            return [ 'status' => false ];
        }
    }

}