<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\IncidentReportingModel;
use HospitalApi\Model\IncidentReportingMessagesModel;
use HospitalApi\Template\IncidentReportingNoticicationEmailTemplate;
use PHPMailer\PHPMailer\Exception;

/**
 * <b>IncidentReportingController</b>
 */
class IncidentReportingController extends ControllerAbstract
{

    public function __construct() {
        parent::__construct(new IncidentReportingModel());
    }

    public function insertChatAction($req, $res, $args) {
        $values = (object)$req->getParsedBody();

        $model = $this->getModel();
        $messagesModel = new IncidentReportingMessagesModel();
        $messageEntity = $messagesModel->mount($values);
        
        $result = $messagesModel->doInsert($messageEntity);
        
        try {
            $incident = $messageEntity->getIncident();
            $user = $messageEntity->getUser();
            
            \Helper\LoggerHelper::initLogFile('incident-reporting-messages', "#".$incident->getId(), 'incident-reporting');

            $transmissionList = $model->getTransmissionList($incident->getId(), $user->getId());
            
            foreach ($transmissionList as $userReceiver) {
                $emailTemplate = new IncidentReportingNoticicationEmailTemplate($incident, $user, $userReceiver);
                EmailController::sendEmailAction($emailTemplate);
            }
            
            $logMessage = $messageEntity->getTime()->format('Y/m/d H:i:s')." ";
            $logMessage .= $user->getName()."(".$user->getGroup()->getName()."): ".$messageEntity->getMessage();
            \Helper\LoggerHelper::writeFile($logMessage);

        } catch(Exception $e) {
            $model = new \HospitalApi\Model\StatusMessageModel();
            $result = $model->getStatus('notification_not_send')->toArray();
        }
        
        return $res->withJson($result);
    }

    public function getChatsByIncident($req, $res, $args) {
        $messagesModel = new IncidentReportingMessagesModel();
        $chats = $messagesModel->findMessagesByIncident($args['id']);
        
        return $res->withJson($chats);
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