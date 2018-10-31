<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\RotineModel;

/**
 * <b>RotineController</b>
 */
class RotineController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new RotineModel());
    }

    public function executeAction($req, $res, $args) {
        $rotine = $req->getParsedBody();
        
        shell_exec($rotine['path']);
        
        return $res->withJson(true);
    }

    public function getRotinesAvailableAction($req, $res, $args) {
        $path = PATH."/Cron/Routines/executables";
        
        $folder = \Helper\DirectoryHelper::getFilesArray($path);
        
        $files = $this->getModel()->getFiles($folder);
        return $res->withJson($files);
    }

    public function getLogsAction($req, $res, $args) {
        $id = $args['id'];
        
        $logs = $this->getModel()->getLogsByRotineId($id);

        $data = $this->translateCollection($this->getModel()->entity);
        $file = $this->getModel()->localizeLogFile($id);
        $data['file'] = $file['name'];
        $data['logs'] = $logs;
        
        return $res->withJson($data);
    }

}