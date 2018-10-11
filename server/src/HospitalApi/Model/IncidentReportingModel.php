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
        $userModel = new \HospitalApi\Model\UserModel();
        $userRepository = $this->em->getRepository('HospitalApi\Entity\User');
        $eventRepository = $this->em->getRepository('HospitalApi\Entity\Event');
        
        $values->place['reportPlace'] = $groupRepository->find($values->place['reportPlace']['id']);
        $values->place['failedPlace'] = $groupRepository->find($values->place['failedPlace']['id']);
        $users = $userModel->getUsersAdminWithEmail($values->place['failedPlace']);
        if(isset($values->id)) {
            foreach ($users as $user) {
                $this->updateTransmissionList($values->id, $user, 'add');
            }
        } else {
            $segerUsersAdmin = $userModel->getUsersAdminWithEmail($groupRepository->findByGroupId('seger-hu'));
            $users = array_merge($users, $segerUsersAdmin);
            $values->transmissionList = new \Doctrine\Common\Collections\ArrayCollection();
            foreach ($users as $user) {
                $values->transmissionList->add($userRepository->find($user->getId()));
            }
        }
        
        $values->event = $eventRepository->find($values->event['id']);
        
        $afterIncident = $this->getRepository()->findOneBy([], ['id'=> 'DESC']);
        $values->id = $afterIncident->getId()+1;

        return $values;
    }

    public function updateTransmissionList($incidentId, $user, $type) {
        $this->entity = $this->getRepository()->find($incidentId);

        if($user instanceOf \HospitalApi\Entity\User) {
            $user = $this->em->getRepository('HospitalApi\Entity\User')->find($user->getId());
        } else {
            $user = $this->em->getRepository('HospitalApi\Entity\User')->find($user->id);
        }

        if($type == 'add') {
            if(!$this->userInList($user) ) {
                $this->entity->addUserToTransmissionList($user);
            }
        } else if($type == 'remove') {
            if($this->userInList($user) ) {
                $this->entity->removeUserToTransmissionList($user);
            }
        }

        $this->doUpdate($this->entity);

        return true;
    }

    public function userInList($user) {
        $res = $this->entity->getTransmissionList()->exists( function($key, $entry) use ($user) {
            return ($entry->getId() == $user->getId());
        });
        return $res;
    }

    public function getTransmissionList($incidentId, $userId) {
        $select = $this->em->createQueryBuilder()
            ->select('u')
            ->from('HospitalApi\Entity\User', 'u')
            ->innerJoin('HospitalApi\Entity\IncidentReporting', 'ir', 'WITH', 'ir.id = :incident')
            ->innerJoin('ir.transmissionList', 'irtl', 'WITH', 'irtl = u')
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
            if($filter != 'failedPlace' && $filter != 'enterpriseWatching' ) {
                if($value == "true" || $value == "false") {
                    $value = ($value == "true") ? 1 : 0;
                }
                $query->andWhere("ir.$filter = :$filter")
                      ->setParameter($filter, $value);
            }
        }
        if(isset($filters['failedPlace'])) {
            $query->innerJoin('ir.transmissionList', 'irtl', 'WITH', "irtl.id = {$filters['failedPlace']} OR ir.failedPlace = {$filters['failedPlace']}")
                  ->groupBy('ir.id');
        }
        $query
            ->innerJoin('ir.failedPlace', 'gf', 'WITH', 'gf.enterprise = :enterpriseWatching' )
            ->setParameter('enterpriseWatching', $filters['enterpriseWatching'])
            ->orderBy('ir.id', 'DESC');
            
        return $query->getQuery()->getResult();
    }


}
