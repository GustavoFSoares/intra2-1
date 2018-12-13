<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\IncidentReportingModel;
use HospitalApi\Model\IncidentReportingMessagesModel;
use HospitalApi\Model\NotificationsIncidentReportingModel;
use HospitalApi\Template\IncidentReportingNoticicationEmailTemplate;
use HospitalApi\Template\AdverseEventsEmailTemplate;
use PHPMailer\PHPMailer\Exception;

/**
 * <b>IncidentReportingController</b>
 */
class IncidentReportingController extends ControllerAbstractLongEntity
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
            
            $model->updateTransmissionList($incident->getId(), $user, 'add');
            NotificationsIncidentReportingModel::deleteNotification($incident, $user);
            foreach ($transmissionList as $userReceiver) {
                NotificationsIncidentReportingModel::plusOne($incident, $userReceiver);

                $emailTemplate = new IncidentReportingNoticicationEmailTemplate($incident, $user, $userReceiver);
                EmailController::sendEmailAction($emailTemplate);
            }
            $this->makeLog($messageEntity, $user);

        } catch(Exception $e) {
            $model = new \HospitalApi\Model\StatusMessageModel();
            $result = $model->getStatus('notification_not_send')->toArray();
        }
        
        return $res->withJson($result);
    }

    public function makeLog($messageEntity, $user) {
        $logMessage = $messageEntity->getTime()->format('Y/m/d H:i:s')." ";
        $logMessage .= $user->getName()."(".$user->getGroup()->getName()."): ".$messageEntity->getMessage();
        \Helper\LoggerHelper::writeFile($logMessage);        
    }

    public function get($req, $res, $args) {
        $id = $req->getQueryParam('id');
		$params = $req->getQueryParams();

		$this->storeUser($params);
		if ($id === null) {
			$data = $this->getModel()->findBy($params);
		} else {
			$results = $this->getModel()->findById($id);
            $data = $this->translateCollection($results);
        }
        
		return $res->withJson($data);
    }
    
    public function closeReportAction($req, $res, $args) {
        $id = $args['id'];

        $model = $this->getModel();
        $messagesModel = new IncidentReportingMessagesModel();
        $notificationsModel = new NotificationsIncidentReportingModel();
        
        $entity = $model->getRepository()->find($id);
        $messagesModel->deleteChats($entity->getId());
        $notificationsModel->deleteNotifications($entity->getId());

        $entity->setClosed(true);

        return $model->doUpdate($entity);
    }

    public function getChatsByIncident($req, $res, $args) {
		$params = $req->getQueryParams();
		$this->storeUser($params);

        $messagesModel = new IncidentReportingMessagesModel();
        $chats = $messagesModel->findMessagesByIncident($params['id']);
        
        return $res->withJson($chats);
    }

    public function insertUserToTransitionList($req, $res, $args) {
        $incidentId = $args['id'];
        $group = (object)$req->getParsedBody();
        
        $response = $this->getModel()->updateTransmissionList($incidentId, $group, 'add');
        
        return $res->withJson($response);
    }
    
    public function removeUserToTransitionList($req, $res, $args) {
        $incidentId = $args['id'];
        $group = (object)$req->getParsedBody();
        
        $response = $this->getModel()->updateTransmissionList($incidentId, $group, 'remove');
        
        return $res->withJson($response);
    }

    public function getHistoricAction($req, $res, $args) {
        $id = $args['id'];
        
        $file = __DIR__ . "/../../../logs/incident-reporting-messages";
        $file = "$file/$id-INCIDENT-REPORTING.log";
        
        $content = [];
        $logs = [];

        if(file_exists($file)) {
            $content = explode("\n", file_get_contents($file));
        }
        
        foreach ($content as $key => $line) {
            if($line) {
                $logs[$key]['time'] = substr($line, 0, 20);
                $logUser = substr($line, 20);
                $logUser = explode(':', $logUser);
                
                $logs[$key]['user'] = $logUser[0];
                $logs[$key]['message'] = $logUser[1];
            }
        }
        
        return $res->withJson($logs);
    }

    public function _mountEntity($values) {
        $entity = parent::_mountEntity($values);

        if($entity->getFailedPlace()->getEnterprise() == 'HPSC') {
            $this->sendEmailFor($entity);
        }
        
        return $entity;
    }

    public function sendEmailFor($incident) {
        $afterIncident = $this->getModel()->getRepository()->findOneBy([], ['id'=> 'DESC']);
        $incident
            ->setId($afterIncident->getId()+1)
            ->setClosed(true);
        $emailTemplate = new AdverseEventsEmailTemplate($incident);
            
        EmailController::sendEmailAction($emailTemplate);
    }

    public function cleanNotificationAction($req, $res, $args) {
        $params = $req->getQueryParams();
        
        $this->storeUser($params);
        $incident = $this->getModel()->findById($params['incident']);
        if($incident) {
            NotificationsIncidentReportingModel::deleteNotification($incident, $this->getContainer()['session']->get());
        }

        return $res->withJson(true);
    }
    
}