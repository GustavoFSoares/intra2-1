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
        //FUNÇÃO RECEBIA $TYPE E $FILENAME
        return \Helper\DirectoryHelper::getFilesArray($this->archives);

        /*
        switch ($type) {
            case 'disease-notification':
                $folder = "$this->archives/fichasDoencasNotificacaoCompulsoria/";
                break;
            
            case 'work-acident':
                $folder = "$this->archives/fluxosAcidentesTrabalho/";
                break;

            case 'organogram':
                $folder = "$this->archives/organogramas/";
                break;
            
            case 'anothers':
                $folder = "$this->archives/outros/";
                break;
            
            case 'certificate-regiment':
                $folder = "$this->archives/regimentosCertidoes/";
                break;

            case 'intern-regiment':
                $folder = "$this->archives/RI/";
                break;
           
            
            default:
                return false;
                break;
        }
        $file = \Helper\DirectoryHelper::getFileInFolder($fileName, $folder);
        
        return $file;
        */
    }
    
    public function getPops() {
        return \Helper\DirectoryHelper::getFilesArray($this->pops);
    }

}