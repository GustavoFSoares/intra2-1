<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\FileModel;

/**
 * <b>FileController</b>
 */
class FileController extends ControllerAbstractLongEntity
{
    private $_model;

    public function __construct() {
        $this->_model = new FileModel();
    }

    public function _getModel() {
        return $this->_model;
    }

    public function getFileAction($req, $res, $args) {
        return \Helper\DirectoryHelper::fileDownload($req->getParam('filePath'), $req->getParam('onScreen'));
    }

    public static function getFilesOfFolder($folderName, $id) {
        $dir = FILES."$folderName/$id";
        $data = [];
        
        if( is_dir($dir) ) {
            $data = \Helper\DirectoryHelper::getFilesArray($dir);
        } 
        
        return $data;
    }

    public function getOrganogramAction($req, $res, $args) {
        
        $fileName = $req->getQueryParam('fileName');
        $file = $this->_getModel()->getFile('organogram', $fileName);
        
        return \Helper\DirectoryHelper::fileDownload($file['path']);
    }

    public function getPopsAction($req, $res, $args) { 
        $files = $this->_getModel()->getPops();
                
        return $res->withJson($files);
    }

    public function getArchivesAction($req, $res, $args) {
        $files = $this->_getModel()->getFile();

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

    public static function removeFile($folderName, $values) {
        if( isset($values['file']) ) {
			$file = $values['file'];

			if( unlink($file['path']) ) {
				$response = true;
			} else {
				new Exception("File not removed", 500);
			}
		} else {
            new Exception("File not found", 500);
        }
        
        return $response;
    }
}