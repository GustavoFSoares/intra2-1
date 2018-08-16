<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\TrainingParticipantModel;

/**
 * <b>TrainingParticipantController</b>
 */
class TrainingParticipantController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new TrainingParticipantModel());
    }

    public function update($req, $res, $args) {
        $trainingId = $args['id'];
        $values = $req->getParsedBody();
        
        $return = $this->getModel()->updateListParticipants($trainingId, $values);
        
        return $res->withJson($return);
    }

    public function delete($req, $res, $args) {
        $values = $req->getParsedBody();
        
        $return = $this->getModel()->doDelete($values['userId'], $values['trainingId']);
        return $res->withJson($return);
    }

    public function insertParticipantOnTraining($req, $res, $args) {
        $trainingId = $args['id'];
        $participant = (object)$req->getParsedBody();
        
        $return = $this->getModel()->addParticipantOnTraining($trainingId, $participant);
        
        return $res->withJson($return);
    }
    
    public function getParticipantsByTraining($req, $res, $args) {
        $trainingId = $args['id'];

        $data = $this->getModel()->findAllParticipantsForTraining($trainingId);
        return $res->withJson($data);
    }

    public function getAllTrainingsForParticipant($req, $res, $args) {
        $participantId = $args['id'];
        
        $data = $this->getModel()->findAllTrainingForParticipants($participantId);
        
        return $res->withJson($data);
    }

}