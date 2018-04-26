<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\AdverseEventsModel;
use PHPMailer\PHPMailer\Exception;

/**
 * <b>AdverseEventsController</b>
 * Classe responsável por criar e enviar Email
 */
class AdverseEventsController extends ControllerAbstract
{

    public function __construct()
    {
        parent::__construct(new AdverseEventsModel());
    }

    public function saveAction($req, $res){
        $values = $req->getParsedBody();

        $this->model->buildData($values);
    }

    

}