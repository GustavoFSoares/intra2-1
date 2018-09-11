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

    public function insertGroupToTransitionList($req, $res, $args) {
        $incidentId = $args['id'];
        $group = (object)$req->getParsedBody();
        
        $response = $this->getModel()->updateTransmissionList($incidentId, $group, 'add');
        
        return $res->withJson($response);
    }
    
    public function removeGroupToTransitionList($req, $res, $args) {
        $incidentId = $args['id'];
        $group = (object)$req->getParsedBody();
        
        $response = $this->getModel()->updateTransmissionList($incidentId, $group, 'remove');
        
        return $res->withJson($response);
    }

    public function _mountEntity($values) {
        $data = $this->getModel()->mount($values);
        return parent::_mountEntity($data);
    }

    public function translateCollection($entity) {
        if(empty($arr)){
			$arr = is_array($entity) ? 
				[] : null;
        }
        
        if($entity) {
            if(is_array($entity)){
                foreach ($entity as $key => $value) {
                    $arr[$key] = $this->translateCollection($value);
                }
            } else {
                $arrayEntity = $entity->toArray();
                foreach ($arrayEntity as $key => $value) {
                    if($value instanceof \HospitalApi\Entity\EntityAbstract){
                        $arr[$key] = $this->translateCollection($value);
        
                    } else {
                        if(array_key_exists($key, $entity->toArray())) {
                            $result = $value;
        
                            if(method_exists($result, "toArray")) {
        
                                foreach ($result->toArray() as $k => $val) {
                                    $arr[$key][$k] = $this->translateCollection($val);
                                }
                                
                            } else {
                                $arr[$key] = $value;
                            }
                        }
                    }
        
                }
                
            }
        }
        return $arr;
    }
    
}