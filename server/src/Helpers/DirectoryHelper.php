<?php
namespace Helper;

class DirectoryHelper {

    public static function getFilesArray($path, $fileToIgnore = null) {
        if(!isset($folder)) {
            $folder = [];
        }
        $dir = new \DirectoryIterator($path);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                if($fileinfo->isDir()) {
                    $folder[] = [
                        'dir' => true,
                        'name' => $fileinfo->getBasename(),
                        $fileinfo->getBasename() => self::getFilesArray($fileinfo->getPathname(), $fileToIgnore)
                    ];
                } else if($fileinfo->getBasename() != $fileToIgnore){
                    $folder[] = [
                        'name' => $fileinfo->getBasename(),
                        'extension' => $fileinfo->getExtension(),
                        'path' => $fileinfo->getPathname(),
                    ];
                }
            }
        }
        return $folder;
    }

    public static function readFiles($path) {
        if( is_dir($path) ){
            $files = scandir($path);
            
            if($files[0] == '.' || $files[0] == '..') { unset($files[0]); }
            if($files[1] == '.' || $files[1] == '..') { unset($files[1]); }

            return array_reverse($files);
        } else {
            new Exception("Folder not Found", 404);
        }
    }
}
