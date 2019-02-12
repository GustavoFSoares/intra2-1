<?php
namespace HospitalApi\Template\Document\Files;

use \HospitalApi\Model\EletronicDocumentModel;
use \HospitalApi\Entity\EletronicDocument;

require_once(PATH.'/../vendor/tecnick.com/tcpdf/tcpdf.php');
class DocumentoEletronicoFile extends \TCPDF {

    public $protocol;
    private $_model;
    private $_EnablePageCounter = true;

    public function __construct($params) {
        $this->_model = new EletronicDocumentModel();

        $this->protocol = $params['id'];
        if(array_key_exists('id', $params)) { 
            $this->_model->entity = $this->_model->getRepository()->find( $params['id'] );
            if(!$this->_model->entity) {
                return;
            }
        }
        
        if(isset($params['pageCount'])) {
            $this->_EnablePageCounter = true;
        }

        parent::__construct();
    }

	//Page header
	public function Header() {
        $imageFile = FILES.'logo/';
        $this->Image($imageFile."logo-hu-04.jpg", 10, 10, 70, false, 'JPG', 'L', '', false, 300, '', false, false, 0, false, false, false);
        
        // $this->SetFont('helvetica', '', 15);
        
        // $this->ln(40);
        // $this->MultiCell(0, 60, "Protocolo nº {$this->protocol} - {$entity->getSubject()}", 0, 'L', 0, 1, '', '', true);
        // $this->ln(2);
        // $this->MultiCell(0, 0, "Canoas, {$entity->getCreatedDate()->format('d/m/Y')}", 0, 'R', 0, 1, '', '', true);

        // $this->Cell(0, 60, "Protocolo nº {$this->protocol} - {$entity->getSubject()}", 0, 0, 'L', 0, '', 0);
        // $this->Cell(0, 100, "Canoas, {$entity->getCreatedDate()->format('d/m/Y')}", 0, 0, 'R', 0, '', 0);
        
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
        
        $this->SetFont('helvetica', 'I', 10);
        
        if($this->_EnablePageCounter) {
            if($this->_model->entity->getSignatureList()->isEmpty() == false) {
                foreach ($this->_model->entity->getSignatureList()->toArray() as $signature) {
                    $user = "{$signature->getUser()->getName()} ({$signature->getUser()->getCode()})";
                    if( $signature->isSigned() && $signature->isAgree() ) {
                        $user .= " - ASSINADO";
                    }

                    $this->MultiCell(0, 0, $user, 0, 'L', 0, 1, '', '', true);
                    $this->ln(1);
                }
            } else {
                $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
            }
            
            $this->SetFont('helvetica', 'I', 8);
            // Page number
            $this->MultiCell(0, 0, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 'C', 0, 0, '', '', true);
        }
    }
    
    public function getContent() {
        $entity = $this->_model->entity;
        
        $html = '';
        $html .= "
            <style>
                .place {
                    text-align: right;
                }

                .test {
                    list-style: none;
                    width: 200px;
                }
            </style>";
        $html .= "
            <body>
                <span class=".'"title"'.">
                    <h3> Protocolo nº {$this->protocol} - {$entity->getSubject()} </h3>
                </span>
                <span class=".'"place"'.">
                    <h3> Canoas, {$entity->getCreatedDate()->format('d/m/Y')} </h3>
                </span>
                
                <div class=".'"content"'.">
                        <span>Prezados Senhores, </span>

                        {$this->_model->entity->getContent()}
                    
                        <ul class=".'"amendment-text"'.">";
                            if($entity->getAmendmentList()->isEmpty() == false) {
                                foreach ($entity->getAmendmentList()->toArray() as $key => $amendment) {
                                $id=$key+1;
                                $html .= "
                                    <li class=".'" "'."><h4>§$id - {$amendment->getTitle()}</h4>
                                        {$amendment->getText()}<br>
                                    </li>";
                                }
                            }
            
            $html .= "</ul>";

      $html .= "</div>
            </body>";
        return $html;
        // echo $html;die;
    }

}