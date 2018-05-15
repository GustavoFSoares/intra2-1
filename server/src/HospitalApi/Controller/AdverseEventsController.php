<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\AdverseEventsModel;
use PHPMailer\PHPMailer\Exception;

/**
 * <b>AdverseEventsController</b>
 */
class AdverseEventsController extends ControllerAbstract
{

    public function __construct() {
        parent::__construct(new AdverseEventsModel());
    }

    public function saveAction($req, $res) {
        $values = (object)$req->getParsedBody();
        $model = $this->getModel();

        return $res->withJson($model->buildData($values));
    }

}