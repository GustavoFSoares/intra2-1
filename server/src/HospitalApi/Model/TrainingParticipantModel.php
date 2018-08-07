<?php

namespace HospitalApi\Model;

use HospitalApi\Entity\TrainingParticipant;
/**
 * <b>TraininglModel</b>
 */
class TrainingParticipantModel extends ModelAbstract
{

    public $entity;

    public function __construct() {
        $this->entity = new TrainingParticipant();
        parent::__construct();
    }

    public function updateListParticipants($trainingId, $values) {
        $userRepository = $this->em->getRepository("HospitalApi\Entity\User");
        $trainingRepository = $this->em->getRepository("HospitalApi\Entity\Training")->find($trainingId);
        $repository = $this->getRepository();

        foreach ($values as $participant) {
            $participant = (object)$participant;
            $participantList = $this->getTrainingParticipant($trainingId, $participant->id);
            
            if($participantList) {
                $participantList->setPresence($participant->presence);

                $this->doUpdate($participantList);
            } else {
                $user = $userRepository->find($participant->id);
                
                $entity = new TrainingParticipant();
                $entity
                    ->setTraining($trainingRepository)
                    ->setParticipant($user)
                    ->setPresence($participant->presence);
                $this->doInsert($entity);
            }
            
        }
        return [ 'status' => true ];

    }

    public function findAllParticipantsForTraining($trainingId) {
        $query = $this->em->createQueryBuilder();

        $query->select([
            'u.id',
             'u.name' ,
             'u.code',
             'u.occupation',
             'u.hire',
             'u.fire',
             'u.turn',
             'u.student',
             'g.id AS GroupId',
             'g.name AS GroupName',
             'g.groupId AS GroupIdName',
             'trp.presence'
            ])
            ->from('HospitalApi\Entity\User', 'u')
            ->innerJoin('HospitalApi\Entity\Group', 'g',
                'WITH', 'u.group = g.id')
            ->innerJoin('HospitalApi\Entity\TrainingParticipant', 'trp', 
                'WITH', 'u.id = trp.participant')
            ->where('trp.training = :trainingId')
            ->orderBy('u.name', 'ASC')
            ->setParameter('trainingId', $trainingId);
        try {
            return $query->getQuery()->getResult(); 
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function getTrainingParticipant($trainingId, $participantId) {
        $query = $this->em->createQueryBuilder();
        $query->select('trp')
            ->from('HospitalApi\Entity\TrainingParticipant', 'trp')
            ->where('trp.participant = :participant')
            ->AndWhere('trp.training = :training')
            ->setParameter('training', $trainingId)
            ->setParameter('participant', $participantId);
        try {
            return $query->getQuery()->getResult()[0]; 
        }
        catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

}