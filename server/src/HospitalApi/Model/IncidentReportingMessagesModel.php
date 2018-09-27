<?php 
namespace HospitalApi\Model;

use HospitalApi\Entity\IncidentReportingMessages;

/**
 * <b>EmailModel</b>
 */
class IncidentReportingMessagesModel extends ModelAbstract
{

    public function __construct() {
        $this->entity = new IncidentReportingMessages();
        parent::__construct();
    }

    public function mount($values) {
        $values->user = $this->em->getRepository('HospitalApi\Entity\User')->find($values->user['id']);
        $values->incident = $this->em->getRepository('HospitalApi\Entity\IncidentReporting')->find($values->id);
        $values->id = 0;
        
        foreach ($values as $key => $value) {
			$method = "set$key";
			$this->entity->$method($value);
        }
        
        return $this->entity;
    }

    public function findMessagesByIncident($idIncident) {
        $query = $this->em->createQueryBuilder();
        $query
            ->select([
                'irm.message',
                'u.name as user',
                'irm.time',
                'irm.read',
            ])
            ->from($this->getEntityPath(), 'irm')
            ->innerJoin('HospitalApi\Entity\User', 'u', 'WITH', 'u = irm.user')
            ->where("irm.incident = :incidentId")
            ->setParameter('incidentId', $idIncident);
        return $query->getQuery()->getResult();
    }

    public function deleteChats($idIncident) {
        $query = $this->em->createQueryBuilder();
        $query
            ->delete($this->getEntityPath(), 'irm')
            ->where('irm.incident = :incidentId')
            ->setParameter('incidentId', $idIncident);
        $query->getQuery()->execute();
    }

}
