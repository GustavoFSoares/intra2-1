<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\AdverseEventsModel;
use HospitalApi\Template\AdverseEventsEmailTemplate;
use PHPMailer\PHPMailer\Exception;

/**
 * <b>AdverseEventsController</b>
 */
class AdverseEventsController extends ControllerAbstract
{

    public function __construct() {
        parent::__construct(new AdverseEventsModel());
    }

    public function sendAction($req, $res) {
        $values = (object)$req->getParsedBody();
        return $res->withJson($this->save($values));
    }

    public function save($values) {
        $model = $this->getModel();

        $report = new AdverseEventsEmailTemplate($values);
        $status = $model->buildData($values);
        if (!$status) {
            return $status;
        }
        $status = EmailController::buildMailAction($report);
        return $status;
        
    }

}