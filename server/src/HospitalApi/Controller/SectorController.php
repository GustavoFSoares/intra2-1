<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\SectorModel;

class SectorController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new SectorModel());
    }

    public function getSectorsByEnterpriseAction($req, $res, $args){
        $model = $this->getModel();
        $id = $args['id'];

        $data = $this->translateCollaction($model->findSectorsByEnterprise($id));
        return $res->withJson($data);
    }
    
}