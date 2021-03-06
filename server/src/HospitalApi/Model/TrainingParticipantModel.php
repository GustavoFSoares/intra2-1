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
                // Treinamento já foi realizado
                if(!$trainingRepository->getDone()){
                    //Se NAO, seguir
                    $user = $userRepository->find($participant->id);
                    
                    $entity = new TrainingParticipant();
                    $entity
                        ->setTraining($trainingRepository)
                        ->setParticipant($user)
                        ->setPresence($participant->presence);
                    $this->doInsert($entity);
                } else {
                    //Se SIM, não inserir novos participantes
                    return ;
                }
            }
            
        }
        return [ 'status' => true ];
    }
    
    public function addParticipantOnTraining($trainingId, $participant) {
        $userRepository = $this->em->getRepository("HospitalApi\Entity\User")->find($participant->id);
        $trainingRepository = $this->em->getRepository("HospitalApi\Entity\Training")->find($trainingId);
        $repository = $this->getRepository();

        $participantList = $this->getTrainingParticipant($trainingId, $participant->id);
            
        $modelStatus = new \HospitalApi\Model\StatusMessageModel();
        if($participantList) {
            $result = $modelStatus->getStatus('in_training')->toArray();
        } else {
            $entity = new TrainingParticipant();
            $entity
                ->setTraining($trainingRepository)
                ->setParticipant($userRepository)
                ->setPresence(false);
            $this->doInsert($entity);
            $result = $modelStatus->getStatus('training_add')->toArray();
        }
        return $result;
    }

    public function findAllParticipantsForTraining($trainingId) {
        $query = $this->em->createQueryBuilder();

        $query->select([
            'u.id',
             'u.name' ,
             'u.code',
             'u.occupation',
             'uc.hire',
             'uc.fire',
             'uc.turn',
             'ut.name AS Tipo',
             'g.id AS GroupId',
             'g.name AS GroupName',
             'g.groupId AS GroupIdName',
             'trp.presence'
            ])
            ->from('HospitalApi\Entity\User', 'u')
            ->innerJoin('HospitalApi\Entity\Group', 'g',
                'WITH', 'u.group = g.id')
            ->leftJoin('HospitalApi\Entity\UserComplement', 'uc',
                'WITH', 'u.id = uc.user')
            ->leftJoin('HospitalApi\Entity\UserType', 'ut',
                'WITH', 'uc.type = ut.id')
            ->innerJoin('HospitalApi\Entity\TrainingParticipant', 'trp', 
                'WITH', 'u.id = trp.participant')
            ->where('trp.training = :trainingId')
            ->orderBy('u.name', 'ASC')
            ->setParameter('trainingId', $trainingId);
        
        return $query->getQuery()->getResult(); 
    }

    public function findAllTrainingForParticipants($participantId) {
        $query = $this->em->createQueryBuilder();
        $log = $this->getLogger();
        $query->select([
            't.id',
            't.name',
            't.beginTime',
            't.endTime',
            't.workload',
            't.enterprise'
            ])
            ->from('HospitalApi\Entity\Training', 't')
            ->innerJoin('HospitalApi\Entity\TrainingParticipant', 'trp', 
                'WITH', 't.id = trp.training AND trp.participant = :participantId')
            ->where('t.beginTime > :now')
            ->andWhere('t.done = 0')
            ->orderBy('t.beginTime')
            ->setParameter('now', new \DateTime())
            ->setParameter('participantId', $participantId) ;
        
            return $query->getQuery()->getResult();        
    }

    public function getTrainingParticipant($trainingId, $participantId) {
        $query = $this->em->createQueryBuilder();
        $query->select('trp')
            ->from('HospitalApi\Entity\TrainingParticipant', 'trp')
            ->where('trp.participant = :participant')
            ->AndWhere('trp.training = :training')
            ->setParameter('training', $trainingId)
            ->setParameter('participant', $participantId);
        
        $data = $query->getQuery()->getResult(); 
        return $data ? $data[0] : null;
    }

    public function doDelete($participantId, $trainingId) {
        $trainingParticipant = $this->getTrainingParticipant($trainingId, $participantId);
        $trainingParticipant->setParticipant(null);
        $trainingParticipant->setTraining(null);
        
        parent::doDelete($trainingParticipant);
        
        return true;
    }

}