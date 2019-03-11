<?php
namespace HospitalApi\Template\Document\Files;

use \HospitalApi\Model\EletronicDocumentModel;
use \HospitalApi\Entity\EletronicDocument;

require_once(PATH.'/../vendor/tecnick.com/tcpdf/tcpdf.php');
class DocumentoEletronicoFile extends \TCPDF {

    public $protocol;

    public $mleft = 20;
    public $mtop = 30;
    public $mright = -1;
    public $header = null;
    public $footer = -13;

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
        
        $signatureList = $this->_model->entity->getSignatureList();
        $this->footer = !$signatureList->isEmpty() ? $signatureList->count() * $this->footer : $this->footer;

        parent::__construct();
    }

	//Page header
	public function Header() {
        $this->SetY(10);
        $imageFile = FILES.'logo/';
        $this->Image($imageFile."logo-hu-04.jpg", 10, 10, 70, false, 'JPG', '', '', false, 300, 'C', false, false, 0, false, false, false);
	}

	// Page footer
	public function Footer() {
        $this->SetY($this->footer);
        $this->SetFont('helvetica', 'I', 10);
        
        foreach ($this->_model->entity->getSignatureList()->toArray() as $signature) {
            $user = "{$signature->getUser()->getName()} ({$signature->getUser()->getCode()})";
            if( $signature->isSigned() && $signature->isAgree() ) {
                $user .= " - ASSINADO ELETRONICAMENTE";
            }

            $this->MultiCell(0, 0, $user, 0, 'R', 0, 1, '', '', true);
            $this->ln(1);
        }

        if($this->_EnablePageCounter) {
            $this->SetFont('helvetica', 'I', 8);
            
            // Page number
            if( !$this->_model->entity->getSignatureList()->isEmpty() ) {
                $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            } else {
                $this->MultiCell(0, 0, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 'R', 0, 0, '', '', true);
            }

        }
    }
    
    public function getContent() {
        $entity = $this->_model->entity;
        
        $html = '';
        $html .= "
            <style>
                .content {
                    text-align: justify;
                }

                .place {
                    text-align: right;
                }

                .signature {
                    text-align: right;
                    font-style: italic;

                }
            </style>";
        $html .= "
            <body>
                <span class=".'"title"'.">
                    <h3>
                        Protocolo nº {$this->protocol}<br>
                        Assunto: {$entity->getSubject()}<br>
                        Remetente: <i>{$entity->getUser()->getName()} ({$entity->getUser()->getCode()})</i>
                    </h3>

                </span>
                <span class=".'"place"'.">
                    <h3> Canoas, {$this->getDate( $entity->getCreatedDate() )} </h3>
                </span>
                
                <div class=".'"content"'.">
                        Prezados Senhores,<br>
                        {$this->_model->entity->getContent()}

                        <ul class=".'"amendment-text"'.">";
                            if($entity->getAmendmentList()->isEmpty() == false) {
                                foreach ($entity->getAmendmentList()->toArray() as $key => $amendment) {
                                $id=$key+1;
                                $html .= "
                                    <li class=".'" "'."><h4>§$id - {$amendment->getTitle()}</h4>
                                        {$amendment->getText()}<br>
                                        <p class=".'"signature"'."> {$amendment->getUser()->getName()} ({$amendment->getUser()->getCode()}) </p>
                                    </li>";
                                }
                            }
            $html .= "</ul>
                </div>
            </body>";
        return $html;
        // echo $html;die;
    }

    public function getDate(\DateTime $date) {
        $day = $date->format('d');
        $month = $this->getMonthName( $date->format('m') );
        $year = $date->format('Y');

        return "$day de $month de $year";
    }

    public function getMonthName($monthNumber) {
        $month = [ '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Março', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro', ];

        return $month[$monthNumber];
    }

}