<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\TrainingModel;

/**
 * <b>TrainingController</b>
 */
class TrainingController extends ControllerAbstractLongEntity
{
    public function __construct() {
        parent::__construct(new TrainingModel());
    }

    public function getUnrealized($req, $res, $args) {
        $collection = $this->getModel()->getUnrealized();
        $data = $this->translateCollection($collection);

        return $res->withJson($data);
    }
    
    public function isDone($req, $res, $args) {
        $id = $args['id'];
        
        $return = $this->getModel()->isDone($id);
        return $res->withJson($return);
    }

}