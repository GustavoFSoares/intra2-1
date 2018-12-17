<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\OmbudsmanModel;
use HospitalApi\Template\Document\DocumentFactory;

/**
 * <b>OmbudsmanController</b>
 */
class OmbudsmanController extends ControllerAbstractLongEntity
{
    public function __construct() {
        parent::__construct(new OmbudsmanModel());
    }

    public function printDocumentAction($req, $res, $args) {
        $params = $req->getParams();
        $params['origin'] = $this->getEntityManager()->getRepository('HospitalApi\Entity\OmbudsmanOrigin')->find($params['origin']);

        new DocumentFactory('Ouvidorias', $params['page'], $params);
        
        exit;
    }

    public function getWaitingAction($req, $res, $args) {
        $params = $req->getParams();
        $data = $this->getModel()->getOmbudsmansWaiting($params);

        return $res->withJson($data);
    }

    public function setManagerResponseAction($req, $res, $args) {
        $values = $req->getParsedBody();
        $values['status'] = 'manager-received';

        $this->getModel()->setResponse($values);
        
        return $res->withJson(true);
    }

    public function setOmbudsmanResponseAction($req, $res, $args) {
        $values = $req->getParsedBody();
        $values['status'] = 'finished';

        $this->getModel()->setResponse($values);
        
        return $res->withJson(true);
    }

    public function addManagerAction($req, $res, $args) {
        $id = $req->getAttribute('id');
        $user = $req->getParsedBody();

        $response = $this->getModel()->addManager($id, $user);

        return $res->withJson($response);
    }

    
}