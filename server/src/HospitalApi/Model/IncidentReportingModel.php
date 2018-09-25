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
        unset($values['transmissionList']);
        $values = (object)$values;
        
        $groupRepository = $this->em->getRepository('HospitalApi\Entity\Group');
        $eventRepository = $this->em->getRepository('HospitalApi\Entity\Event');
        
        $values->place['reportPlace'] = $groupRepository->find($values->place['reportPlace']['id']);
        $values->place['failedPlace'] = $groupRepository->find($values->place['failedPlace']['id']);
        if(isset($values->id)) {
            $this->updateTransmissionList($values->id, $values->place['failedPlace'], 'add');
        } else {
            $values->transmissionList = new \Doctrine\Common\Collections\ArrayCollection();
            $values->transmissionList->add($values->place['failedPlace']);
        }
        
        $values->event = $eventRepository->find($values->event['id']);

        return $values;
    }

    public function updateTransmissionList($incidentId, $group, $type) {
        $this->entity = $this->getRepository()->find($incidentId);

        if(!$group instanceOf \HospitalApi\Entity\Group) {
            $group = $this->em->getRepository('HospitalApi\Entity\Group')->find($group->id);
        }

        if($type == 'add') {
            if(!$this->groupInList($group) ) {
                $this->entity->addGroupToTransmissionList($group);
            }
        } else if($type == 'remove') {
            if($this->groupInList($group) ) {
                $this->entity->removeGroupToTransmissionList($group);
            }
        }

        $this->doUpdate($this->entity);

        return true;
    }

    public function groupInList($group) {
        $res = $this->entity->getTransmissionList()->exists( function($key, $entry) use ($group) {
            return ($entry->getId() == $group->getId());
        });
        return $res;
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

    public function findBy($filters) {
        $query = $this->em->createQueryBuilder();
        $query->select('ir')->from($this->getEntityPath(), 'ir');

        foreach ($filters as $filter => $value) {
            if($filter != 'failedPlace') {
                $query->andWhere("ir.$filter = :$filter")
                      ->setParameter($filter, $value);
            }
        }
        if(isset($filters['failedPlace'])) {
            $query->innerJoin('ir.transmissionList', 'irtl', 'WITH', "irtl.id = {$filters['failedPlace']} OR ir.failedPlace = {$filters['failedPlace']}")
                  ->groupBy('ir.id');
        }
        $query->orderBy('ir.id', 'DESC');
            
        return $query->getQuery()->getResult();
    }


}
