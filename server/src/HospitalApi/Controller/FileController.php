<?php
namespace HospitalApi\Controller;

use HospitalApi\BasicApplicationAbstract;
use HospitalApi\Model\FileModel;

/**
 * <b>FileController</b>
 */
class FileController extends BasicApplicationAbstract
{
    private $_model;

    public function __construct() {
        $this->_model = new FileModel();
    }

    public function getModel() {
        return $this->_model;
    }

    public function getFileAction($req, $res, $args) {
        return \Helper\DirectoryHelper::fileDownload($req->getParam('filePath'), $req->getParam('onScreen'));
    }

    public function getOrganogramAction($req, $res, $args) {
        
        $fileName = $req->getQueryParam('fileName');
        $file = $this->getModel()->getFile('organogram', $fileName);
        
        return \Helper\DirectoryHelper::fileDownload($file['path']);
    }

    public function getPopsAction($req, $res, $args) { 
        $files = $this->getModel()->getPops();
                
        return $res->withJson($files);
    }

    public function checkFileExistAction($req, $res, $args) {
        $file = FILES.$req->getParam('partialPath');
        if( file_exists($file) ) {
            $response = $file;
        } else {
            $response = false;
        }

        return $res->withJson($response);
    }
}