<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\IncidentOriginModel;

class IncidentOriginController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new IncidentOriginModel());
    }

    public function getEnterprises($req, $res, $args) {
        $data = $this->getModel()->findEnterprises();
        return $res->withJson($data);
    }

    public function getOriginsByEnterprise($req, $res, $args) {
        $enterprise = $args['enterprise'];
        $collection = $this->getModel()->getRepository()->findByEnterprise($enterprise);

        $data = $this->translateCollection($collection);
        $transData = [];
        foreach ($data as $item) {
            if ($item['c_removed'] == 0) {
                array_push($transData, $item['name']);
            }
        }
        return $res->withJson($transData);
    }

}