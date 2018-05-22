<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\AlertModel;
use DateTime;

/**
 * <b>AlertController</b>
 */
class AlertController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new AlertModel());
    }

    /**
     * @method getByType()
     * @param String type
     * 
     * Recebe uma String "tipo" e busca o último 
     * registro no Banco de Dados desse tipo.
     * Após isso verifica se ele ainda possui tempo hábil,
     * e retorna o registro desse Alerta
     * @return JSON Alert
     */
    public function getByType($req, $res, $args){
        $type = $args['type'];
        $model = $this->getModel();

        $result = $model->findOneByType($type);
        $data = $this->translateCollaction($result);
        
        if(!$model->isToday($data['c_created'])) {
            $data = null;
        }
        return $res->withJson($data);
    }

}
