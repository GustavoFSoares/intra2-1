<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\LinkModel;

/**
 * <b>LinkController</b>
 */
class LinkController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new LinkModel());
    }

    public function uploadFileAction($req, $res, $args) {
		$files = $req->getUploadedFiles();
		$prefix = $req->getParam('prefix');
		$name = $req->getParam('name');

		if(array_key_exists('file', $files)) {
			$file = $files['file'];
            
            $destiny = PATH."../../../client/";
            if( $this->isProduction() ) {
                $destiny .= "dist/";
            }
            $destiny .= "static/img/links/";
            
			if($prefix) {
				$destiny .= "$prefix/";
			}

			if( !is_dir($destiny) ) {
				mkdir($destiny);
			}
			
			$name = $name ? $name : $file->getClientFilename();
			preg_match_all('/(\.\w{3})$/m', $name, $matches, PREG_SET_ORDER, 0);
			if( isset($matches[0]) ) {
				$fileName = $name;
			} else {
				$extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
				$fileName = "$name.$extension";			
			}
			$fileArray = explode('.', $fileName);
			$name = \Helper\SlugHelper::get( $fileArray[0] );
			$extension = $fileArray[1];
			
			$fileName = "$name.$extension";
			$destiny .= $fileName;
			
			$file->moveTo($destiny);
			$response = $destiny;

		} else {
			$res->withCode(401);
			$response = "File Not Found";
		}

		return $res->withJson($fileName);
    }
    
    public function changeStatusAction($req, $res, $args) {
        $id = $req->getParam('id');

        return $this->getModel()->changeStatus($id);
    }

}