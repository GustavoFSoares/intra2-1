<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\IncidentReportingModel;
use HospitalApi\Template\IncidentReportingEmailTemplate;
use PHPMailer\PHPMailer\Exception;

/**
 * <b>IncidentReportingController</b>
 */
class IncidentReportingController extends ControllerAbstract
{

    public function __construct() {
        parent::__construct(new IncidentReportingModel());
    }

    public function _mountEntity($values) {
        $data = $this->getModel()->mount($values);
        return parent::_mountEntity($data);
    }
    
}