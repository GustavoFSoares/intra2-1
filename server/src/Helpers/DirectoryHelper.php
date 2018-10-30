<?php
namespace Helper;

class DirectoryHelper {
    public static function getFilesArray($path) {
        if(isset($folder)) {
            $folder = [];
        }
        $dir = new \DirectoryIterator($path);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                if($fileinfo->isDir()) {
                    $folder[$fileinfo->getFilename()] = self::getFilesArray($fileinfo->getPathname());
                } else {
                    $folder[$fileinfo->getFilename()] = $fileinfo->getPathname();
                }
            }
        }
        return $folder;
    }
}
