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

    public static function getLogs($class, $id) {
        $re = '/[A-Z][a-z]*/';
        preg_match_all($re, $class, $classArray);
        
        if( !isset($classArray[0]) ) {
            return false;
        } else {
            $classArray = $classArray[0];
        }

        $class = strtoLower( implode('-', $classArray ) );
        $file = LOGS."$class/$id";
        foreach ($classArray as &$breakName) {
            if( strToUpper($breakName) != "MESSAGES" ) {
                $file .= "-".strToUpper($breakName);
            }
        }
        $file .= ".log";
        
        $content = [];
        $logs = [];

        if(file_exists($file)) {
            $content = explode("\n", file_get_contents($file));
        }
        
        foreach ($content as $key => $line) {
            if($line) {
                $logs[$key]['time'] = substr($line, 0, 20);
                $logUser = substr($line, 20);
                $logUser = explode(':', $logUser);
                
                $logs[$key]['user'] = $logUser[0];
                $logs[$key]['message'] = $logUser[1];
            }
        }
        
        return $logs;
    }


}

interface LoggerHelperInterface {
    
    public static function initLogFile($type, $fileName, $sufixe);
    
}