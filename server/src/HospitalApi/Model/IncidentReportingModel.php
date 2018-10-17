<?php 
namespace HospitalApi\Model;

use HospitalApi\Entity\IncidentReporting;
use Doctrine\ORM\QueryBuilder;


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
        
        $values->event = $eventRepository->find($values->event['id']);
        

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

    public function userInList($user, $id = null) {
        $entity = null;
        if($this->entity->getId()) {
            $entity = $this->entity;
        } else if($id) {
            $entity = $this->getRepository()->find($id);
        }

        if($entity) {
            $res = $entity->getTransmissionList()->exists( function($key, $entry) use ($user) {
                return ($entry->getId() == $user->getId());
            });
        } else {
            $res = false;
        }
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

    public function findById($id) {
        $select = $this->em->createQueryBuilder();
        $select->select('ir')->from($this->getEntityPath(), 'ir');

        $select = $this->showForJustWhoCanSee($select)->where("ir.id = $id");

        return $select->getQuery()->getOneOrNullResult();
    }

    public function findBy($filters) {
        $select = $this->em->createQueryBuilder();
        $select->select('ir')->from($this->getEntityPath(), 'ir');

        $select = $this->showForJustWhoCanSee($select)->orderBy('ir.id', 'DESC');
        
        foreach ($filters as $filter => $value) {
            if($filter != 'failedPlace' && $filter != 'enterpriseWatching' ) {
                if($value == "true" || $value == "false") {
                    $value = ($value == "true") ? 1 : 0;
                }
                $select->andWhere("ir.$filter = :$filter")
                      ->setParameter($filter, $value);
            }
        }
            
        return $select->getQuery()->getResult();
    }

    public function showForJustWhoCanSee(QueryBuilder $select ) {
        switch ($this->getContainer()['session']->gotPermission('incident-reporting')) {
            case 'ALL_DATA':
                break;
            
            case 'HU_DATA':
                $select->innerJoin('ir.failedPlace', 'irfp', 'WITH', "irfp.enterprise <> 'HPSC'");
                break;
            
            case 'HPSC_DATA':
                $select->innerJoin('ir.failedPlace', 'irfp', 'WITH', "irfp.enterprise like 'HPSC'");
                break;
            
            default: 
                $select
                    ->innerJoin('ir.transmissionList', 'irtl', 'WITH', "irtl = :user")
                    ->setParameter('user', $this->getContainer()['session']->get()->getId())
                    ->where('ir.filtered = 1');
                break;
        }
       
        return $select;
    }

    public function gotPermission($id) {
        $permission = $this->getContainer()['session']->gotPermission('incident-reporting');
        if($permission == 'USER') {
            $permission = 
                $this->userInList($this->getContainer()['session']->get(), $id) ? "USER" : false;
        }

        return $permission;
    }

}
