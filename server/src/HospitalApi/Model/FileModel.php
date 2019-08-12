<?php
namespace HospitalApi\Model;

use HospitalApi\BasicApplicationAbstract;

/**
* <b>FileModel</b>
 */
class FileModel extends BasicApplicationAbstract
{

    public $entity;

    public function __construct() { }

    public $archives = DOCS."arquivos";
    public $commissions = DOCS."comissoes";
    public $pops = DOCS."pots";
    public $ombudsman = DOCS."ouvidoria";

    public function getFile() {
        return \Helper\DirectoryHelper::getFilesArray($this->archives);

    }

    public function getComissions() {
        return \Helper\DirectoryHelper::getFilesArray($this->commissions);
    }
    
    public function getPops() {
        return \Helper\DirectoryHelper::getFilesArray($this->pops);
    }

}