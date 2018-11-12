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
                        'name' => utf8_encode($fileinfo->getBasename()),
                        $fileinfo->getBasename() => self::getFilesArray($fileinfo->getPathname(), $fileToIgnore)
                    ];
                } else if($fileinfo->getBasename() != $fileToIgnore){
                    $folder[] = [
                        'name' => utf8_encode($fileinfo->getBasename()),
                        'extension' => $fileinfo->getExtension(),
                        'path' => utf8_encode($fileinfo->getPathname()),
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

    public static function getFileInFolder($file, $folder) {
        $dir = new \DirectoryIterator($folder);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                if($fileinfo->isDir()) {
                    
                    self::getFileInFolder($file, $fileinfo->getPathname());
                
                } else if($fileinfo->getBasename() == $file){
                    
                    return [
                        'name' => utf8_encode($fileinfo->getBasename()),
                        'extension' => $fileinfo->getExtension(),
                        'path' => utf8_encode($fileinfo->getPathname()),
                    ];

                }

            }
        }
        return false;
    }

    public static function fileDownload($file) {
        if ( file_exists($file) ) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment;filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            
            readfile($file);
            exit;
        } else {
            return 'File Not found';
        }
    }
}
