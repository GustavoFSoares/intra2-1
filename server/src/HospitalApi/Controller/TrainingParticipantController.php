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

    public function update($req, $res, $args){
        $trainingId = $args['id'];
        $values = $req->getParsedBody();
        
        $model = $this->getModel();

        $return = $model->updateListParticipants($trainingId, $values);
        
        return $res->withJson($return);
    }
    
    public function getParticipantsByTraining($req, $res, $args) {
        $trainingId = $args['id'];

        $data = $this->getModel()->findAllParticipantsForTraining($trainingId);
        return $res->withJson($data);
    }

}