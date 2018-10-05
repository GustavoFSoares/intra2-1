<?php
namespace Helper;

class LoggerHelper implements LoggerHelperInterface {

    public static $date;
    public static $begin;
    public static $end;
    public static $fileDir;

    public static function initializer(){
        self::$begin = new \DateTime();
    }

    public static function get($var){
        self::initializer();
        return self::$slug->slugify($var);
    }

    public static function initLogFile($type, $prefixe = null, $fileName, $formatDate = null) {
        self::initializer();
        
        $file = '';
        if($prefixe) {
            $file .= $prefixe."-";
        }

        if($formatDate) {
            $file .= self::$begin->format($formatDate)."-";
        }
        
        if($fileName) {
            $file .= $fileName;
        }

        $file = \Helper\SlugHelper::get($file);
        $file = strtoupper($file).".log";

        $folderDir = PATH."/../logs/$type";
        if(!is_dir($folderDir)) { 
           $mk = mkdir($folderDir, 0777, true);
        }
        self::$fileDir = "$folderDir/$file";
        
        file_put_contents(self::$fileDir, "", FILE_APPEND);
    }

    public static function writeFile($value) {
        $value = str_replace("\n", "  ", $value);

        file_put_contents(self::$fileDir, "$value\n", FILE_APPEND);
        return $value."\n";
    }


}

interface LoggerHelperInterface {
    
    public static function initLogFile($type, $fileName, $sufixe);
    
}