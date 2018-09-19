<?php 
namespace HospitalApi\Model;

use HospitalApi\Entity\IncidentReporting;

/**
 * <b>EmailModel</b>
 */
class IncidentReportingModel extends ModelAbstract
{

    public function __construct() {
        $this->entity = new IncidentReporting();
        parent::__construct();
    }

    public function mount($values) {
        $values = (object)$values;
        
        $groupRepository = $this->em->getRepository('HospitalApi\Entity\Group');
        $eventRepository = $this->em->getRepository('HospitalApi\Entity\Event');
        
        $values->place['reportPlace'] = $groupRepository->find($values->place['reportPlace']['id']);
        $values->place['failedPlace'] = $groupRepository->find($values->place['failedPlace']['id']);

        $values->transmissionList = [$values->place['failedPlace']];
        $values->event = $eventRepository->find($values->event['id']);

        return $values;
    }

    public function updateTransmissionList($incidentId, $group, $type) {
        $this->entity = $this->getRepository()->find($incidentId);

        $group = $this->em->getRepository('HospitalApi\Entity\Group')->find($group->id);
        if($type == 'add') {
            $this->entity->addGroupToTransmissionList($group);
        } else if($type == 'remove') {
            $this->entity->removeGroupToTransmissionList($group);
        }

        $this->doUpdate($this->entity);

        return true;
    }

    public function getTransmissionList($incidentId, $userId) {
        $select = $this->em->createQueryBuilder()
            ->select('u')
            ->from('HospitalApi\Entity\User', 'u')
            ->innerJoin('HospitalApi\Entity\IncidentReporting', 'ir', 'WITH', 'ir.id = :incident')
            ->innerJoin('ir.transmissionList', 'irtl', 'WITH', 'irtl = u.group')
            ->where('u.admin = 1')
            ->andWhere('u.id != :user')
            ->andWhere('u.c_removed = 0')
            ->andWhere('u.email != :emailNull')
            ->setParameter('emailNull', "")
            ->setParameter('user', $userId)
            ->setParameter('incident', $incidentId);
        return $select->getQuery()->getResult();
    }

    public function findBy($filter) {
        return $this->getRepository()->findBy($filter, ['id'=>'desc']);
    }


}
