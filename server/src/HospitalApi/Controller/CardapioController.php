<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\CardapioModel;

/**
 * <b>CardapioController</b>
 */
class CardapioController extends ControllerAbstractLongEntity
{
    public function __construct() {
        parent::__construct(new CardapioModel());
    }

    public function update($req, $res, $args) {
        $response = parent::update($req, $res, $args);
        return $response;
    }

    public function getNextMeal($req, $res, $args) {
        $collection = $this->getModel()->getNextMeal();
        $data = $this->translateCollection($collection);
        
        return $res->withJson($data);
    }

    public function getCardapios($req, $res, $args) {
        $collection = $this->getModel()->getCardapios();
        $data = $this->translateCollection($collection);

        return $res->withJson($data);
    }
}