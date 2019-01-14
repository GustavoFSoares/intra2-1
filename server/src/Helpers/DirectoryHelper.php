<?php
namespace Helper;
use UnexpectedValueException;

class DirectoryHelper {

    private static $extensionsToIgnore = [
        'db' => 'DB',
    ];

    public static function getFilesArray($path, $fileToIgnore = null, $fileinfo = null) {
        $father = $fileinfo ? $fileinfo->getBasename() : 'root';

        try {
            $dir = new \DirectoryIterator($path);
        }catch(UnexpectedValueException $e) {
            return ['error' => true, 'message' => 'Directory not found!'];
        }
        $folder = null;
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                if($fileinfo->isDir()) {
                    $folder[] = [
                        'dir' => true,
                        'father' => $father,
                        'name' => utf8_encode($fileinfo->getBasename()),
                        $fileinfo->getBasename() => self::getFilesArray($fileinfo->getPathname(), $fileToIgnore, $fileinfo),
                    ];
                } else if($fileinfo->getBasename() != $fileToIgnore){
                    if(self::isValidExtension( $fileinfo->getExtension() )) {
                        $folder[] = [
                            'name' => utf8_encode($fileinfo->getBasename()),
                            'father' => $father,
                            'extension' => $fileinfo->getExtension(),
                            'path' => utf8_encode($fileinfo->getPathname()),
                        ];
                    }
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
                    
                    if(self::isValidExtension( $fileinfo->getExtension() )) {
                        return [
                            'name' => utf8_encode($fileinfo->getBasename()),
                            'extension' => $fileinfo->getExtension(),
                            'path' => utf8_encode($fileinfo->getPathname()),
                        ];
                    }

                }

            }
        }
        return false;
    }

    public static function fileDownload($file, $onScreen = false) {
        if ( file_exists($file) ) {
            if($onScreen) {
                header('Content-type: application/pdf');
                header('Content-Disposition: inline; filename="'.basename($file).'"');
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
            } else {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment;filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
            }
            header('Content-Length: ' . filesize($file));

            readfile($file);
            exit;
        } else {
            return 'File Not found';
        }
    }

    private static function isValidExtension($extension) {
        return !array_key_exists($extension, self::$extensionsToIgnore);
    }
}
