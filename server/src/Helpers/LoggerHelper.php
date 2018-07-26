<?php
namespace Helper;

class LoggerHelper {

    public static $date;
    public static $begin;
    public static $end;
    public static $fileDir;

    public function initializer(){
        self::$begin = new \DateTime();
    }

    public static function get($var){
        self::initializer();
        return self::$slug->slugify($var);
    }

    public static function initLogFile($fileName) {
        self::initializer();

        $fileName= self::$begin->format('Ymd H.i.s')."-".strtoupper($fileName).".log";
        self::$fileDir = "..\..\..\..\logs\Cron\\$fileName";
        
        file_put_contents(self::$fileDir, "", FILE_APPEND);
    }

    public static function writeFile($value) {
        echo "$value";
        file_put_contents(self::$fileDir, $value, FILE_APPEND);
    }


}