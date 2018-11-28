<?php
namespace HospitalApi\Template\Document;

/**
 * <b>OmbudsmanDocumentTemplate</b>
 * Contem o template para Documento de Ouvidoria
 */
class DocumentFactory
{

    public $doc;
    public $type;
    public $numberPage;

    public function __construct($DocumentEntity, $pages = 1, $params = []) {
        unset($params['page']);
        $class = __NAMESPACE__."\Files\\{$DocumentEntity}File";
        
        if(!class_exists($class)) {
            throw new \Exception("Classe >> $class << não encontrada", 404);
        }
        $this->doc = new $class($params);

        $this->doc->SetCreator(PDF_CREATOR);
        $this->doc->SetAuthor('Gustavo Soares');
        $this->doc->SetTitle($DocumentEntity);
        $this->doc->SetSubject($DocumentEntity);
        $this->doc->SetKeywords("TCPDF, PDF, application, pdf-generator, $DocumentEntity");

        $this->doc->SetFont('times', '', 12);
        
        // add a page
        for ($i=0; $i < $pages; $i++) {
            $this->doc->AddPage();

            $this->doc->ln(12);
            $this->doc->writeHTML($this->doc->getContent(), true, false, true, false, '');

        }
        $this->doc->Output("$DocumentEntity.pdf", 'I');
        
    }

}
