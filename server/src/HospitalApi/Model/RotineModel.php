<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\Rotine;

/**
* <b>RotineModel</b>
 */
class RotineModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new Rotine();
        parent::__construct();
    }

    public function findBy($filters = [], $orders = []) {
        $orders['id'] = 'DESC';
        return parent::findBy($filters, $orders);
    }

    public function localizeLogFile($rotineId) {
        $this->entity = $this->findById($rotineId);
        
        $folder = PATH."/../logs/{$this->entity->getTarget()}";
        $files = \Helper\DirectoryHelper::readFiles($folder);
        
        foreach ($files as $file) {
            $target = "ID{$this->entity->getId()}";
            if( substr_compare($file, $target, 0, strlen($target) ) == 0) {
                return [ 'folder' => $folder, 'name' => $file ];
            }
        }
        return false;
    }

    public function getLogsByRotineId($rotineId) {
        $file = $this->localizeLogFile($rotineId);
        $content = false;
        
        if($file) {
            $file = "{$file['folder']}/{$file['name']}";
    
            $content = [];
            $logs = [];
    
            if(file_exists($file)) {
                $content = explode("\n", file_get_contents($file));
            }
        }

        return $content;
    }

    public function getFiles($folder) {
        $filesShowed = [];
        foreach ($folder as $key => $file) {
            if( isset($file['dir']) )  {
                $files = $this->getFiles([ $file[$file['name']] ]);
                $filesShowed = array_merge($filesShowed, $files);
            } else {
                if( isset($file['name']) ) {
                    $filesShowed[] = $file;
                } else {
                    foreach ($file as $file) {
                        $filesShowed[] = $file;
                    }
                }
            }
        }

        return $filesShowed;
    }

}