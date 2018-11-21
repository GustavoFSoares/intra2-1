<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\OmbudsmanDemandsModel;
use HospitalApi\Template\Document\DocumentFactory;

/**
 * <b>OmbudsmanController</b>
 */
class OmbudsmanController extends ControllerAbstractLongEntity
{
    public function __construct() {
        parent::__construct(new OmbudsmanDemandsModel());
    }

    public function printDocumentAction($req, $res, $args) {
        $params = $req->getParams();
        
        new DocumentFactory('Ouvidorias', $params['page'], $params);
        
        exit;
    }


}