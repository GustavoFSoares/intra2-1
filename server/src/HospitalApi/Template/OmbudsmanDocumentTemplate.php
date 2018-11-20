<?php
namespace HospitalApi\Template;

require_once(PATH.'/../vendor/tecnick.com/tcpdf/tcpdf.php');


/**
 * <b>OmbudsmanDocumentTemplate</b>
 * Contem o template para Documento de Ouvidoria
 */
class OmbudsmanDocumentTemplate
{

    public $doc;
    public $numberPage;

    public function __construct($numberPage = 1, $type = '') {
        
        $this->numberPage = $numberPage;
        $this->doc = new \TCPDF();
    }

   public function setLogo() {
       $this->doc->Image();
   }


}