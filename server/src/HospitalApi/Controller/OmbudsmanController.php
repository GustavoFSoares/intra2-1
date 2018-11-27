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

    
}