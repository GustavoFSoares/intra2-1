<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\SectorModel;

class SectorController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new SectorModel());
    }

    public function getSectorsByEnterpriseAction($req, $res){
        $model = $this->getModel();
        
        return $res->withJson($model->findSectorsByEnterprise('upa-rio-branco'));
    }

}