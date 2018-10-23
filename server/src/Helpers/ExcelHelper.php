<?php
namespace Helper;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class ExcelHelper {

    public static $file;
    public static $type;
    
    public function __construct($type) {
        return self::initializer($type);
    }

    public static function initializer($type){
        if($type == null && !self::$file) {
            new Exception("You must set a TYPE of the file", 1);
        } else if(!self::$file) {
            switch ($type) {
                case 'csv':
                    $type = Type::CSV;
                    break;
               
                case 'ods':
                    $type = Type::ODS;
                    break;
                
                default:
                    $type = Type::XLSX;
                    break;
    
                }

                self::$type = $type;
                self::$file = ReaderFactory::create($type);
        }
        return self::$file;
    }

    public function loadFile($filePath) {
        self::$file->open($filePath);
    }

    public function getField() {
        return self::$file->parser->getField();
    }
    
    public function getRows() {
        $data = [];

        foreach (self::$file->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $data[] = $row;
            }
        }

        self::$file->close();
        return $data;
    }

    public function setName($name) {
        self::$file->setName($name);

        return self::$file;
    }

    public function addRows(Array $data) {
        self::$file->addRows($data);

        return self::$file;
    }
    
    public function addRow(Array $data) {
        self::$file->addRow($data);

        return self::$file;
    }
    
    public function save($fileName) {
        self::$file->writer->saveFile($fileName.self::$type);

        return self::$file;
    }

    /** DATA EXEMPLE
     * array (
     *     array('ID',  'Name',            'Kode'  ),
     *     array('1',   'Kab. Bogor',       '1'    ),
     *     array('2',   'Kab. Cianjur',     '1'    ),
     *     array('3',   'Kab. Sukabumi',    '1'    ),
     *     array('4',   'Kab. Tasikmalaya', '2'    )
     * ) 
     */
    public static function export(Array $data, $fileName, $type, $delimiter = null) {
        $file = new ExcelHelper($type);
        $file->addRows($data);
        if ($delimiter) {
            $file->setFieldDelimiter($delimiter);
        }
        $file
            ->openToBrowser($fileName)
            ->close();
    }
}
