<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\CovenantsModel;
use DateTime;

/**
 * <b>CovenantsController</b>
 */
class CovenantsController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new CovenantsModel());
    }

    public function delete($req, $res, $args) {
        $id = $args['id'];
        $model = $this->getModel();
		$repository = $model->getRepository()->find($id);
		$delete = $model->doDelete($repository);

		return $res->withJson($delete);
    }

    public function changeStatus($req, $res, $args) {
        $id = $args['id'];
        $model = $this->getModel();

        $repository = $model->getRepository()->find($id);
        $repository
            ->setC_removed(!$repository->isRemoved());

        $update = $model->doUpdate($repository);

        return $res->withJson($update);
    }
}
