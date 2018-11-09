<?php 
namespace HospitalApi\Model;

use HospitalApi\Entity\NotificationsIncidentReporting;
use HospitalApi\Entity\IncidentReporting;
use HospitalApi\Entity\User;

/**
 * <b>NotificationsIncidentReportingModel</b>
 */
class NotificationsIncidentReportingModel extends ModelAbstract
{

    public function __construct() {
        $this->entity = new NotificationsIncidentReporting();
        parent::__construct();
    }

    public static function plusOne(IncidentReporting $incident, User $user) {
        $model = new NotificationsIncidentReportingModel();
        
        if($notification = $model->existRegister($incident, $user)) {
            $notification->plusOne();

            $model->doUpdate($notification);
        } else {
            
            $model->entity->setIncident( $model->em->getRepository('HospitalApi\Entity\IncidentReporting')->find($incident->getId()) );
            $model->entity->setUser( $model->em->getRepository('HospitalApi\Entity\User')->find($user->getId()) );

            $model->doInsert($model->entity);
        }
    }

    public function existRegister(IncidentReporting $incident, User $user) {
        return $this->getRepository()->findOneBy(['incident' => $incident->getId(), 'user' => $user->getId()]);
    }

    public static function deleteNotification(IncidentReporting $incident, User $user) {
        $model = new NotificationsIncidentReportingModel();
        $notification = $model->existRegister($incident, $user);
        
        $return = "";
        if($notification) {
            $return = $model->doDelete($notification);
        }
        return $return;
    }

    public function deleteNotifications($idIncident) {
        $query = $this->em->createQueryBuilder();
        $query
            ->delete($this->getEntityPath(), 'nir')
            ->where('nir.incident = :incidentId')
            ->setParameter('incidentId', $idIncident);
        $query->getQuery()->execute();
    }

}
