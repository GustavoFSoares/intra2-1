<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\EmailModel;
use PHPMailer\PHPMailer\Exception;
use HospitalApi\Template\EmailTemplateAbstract;

/**
 * <b>EmailController</b>
 */
class EmailController extends ControllerAbstract
{

    public function __construct() {
        parent::__construct(new EmailModel());
    }

    /**
     * @method buildMailAction() 
     * O buildMail() é uma ação que recebe
     * as informações do Email formatadas e envia para
     * montar a estrutura do Email
     * 
     * @param [Request] $req
     * @param [Response] $res
     * @return boolean Status
     */
    public static function sendEmailAction($report) {
        try {
            if(!$report instanceof EmailTemplateAbstract ){
                throw new Exception("\$report must be a EmailTemplate Instance", 400);
            }
            
            $model = new EmailModel($report);
            $email = $model->createEmail();
            
            return $email->send();
            
        } catch (Exeption $e){
            return $e->getMessage();
        }

    }

}