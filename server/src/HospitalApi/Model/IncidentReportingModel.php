<?php 
namespace HospitalApi\Model;

use HospitalApi\Entity\IncidentReporting;
use HospitalApi\Entity\Enterprise;
use HospitalApi\Entity\Sector;
use HospitalApi\Entity\Event;
use HospitalApi\Entity\BossSector;

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


}
