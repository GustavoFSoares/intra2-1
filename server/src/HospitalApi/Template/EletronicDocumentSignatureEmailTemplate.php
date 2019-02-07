<?php
namespace HospitalApi\Template;
use HospitalApi\Entity\EletronicDocument;
use HospitalApi\Entity\User;

/**
 * <b>EletronicDocumentSignatureEmailTemplate</b>
 * Contem o template padrão do email de Documento Eletrônico referente a assinatura
 */
class EletronicDocumentSignatureEmailTemplate extends EmailTemplateAbstract
{

    public function __construct(EletronicDocument $eletronicDocument, User $nextUser) {
        $this
            ->setSubject($eletronicDocument) 
            ->setSender($eletronicDocument->getId()) 
            ->setReceiver($nextUser) 
            ->setBody($eletronicDocument, $nextUser); 
    }

    public function setSubject($eletronicDocument) {
        $this->subject = "Protoco {$eletronicDocument->getId()} - Documento Eletrônico - {$eletronicDocument->getSubject()}";

        return $this;
    }
    
    public function setSender($eletronicDocumentId) {
        $sender = $this->getEmailDefault();
        $sender['name'] = "Documento Eletrônico";

        $this->sender = $sender;
        
        return $this;
    }

    public function setReceiver($nextUser) {
        parent::setReceiver($nextUser->getEmail());
        
        return $this;
    }

    public function setBody($eletronicDocument, $nextUser) {
        $this->body = 
            "<h2>Documento {$eletronicDocument->getId()}</h2>

            Prezado {$nextUser->getName()},
            <br><br>
            O sr. <b>{$eletronicDocument->getUser()->getName()} (<i>{$eletronicDocument->getUser()->getGroup()->getName()}</i>)</b> solicitou sua leitura e validação em um documento.

            <fieldset> 
                <div style='text-align: center'>
                    <a href=http://{$_SERVER['SERVER_NAME']}:8080/usuario/documentos-eletronicos/detalhe/{$eletronicDocument->getId()}>
                        Protocolo <b>{$eletronicDocument->getId()}</b> Documento Eletronico - {$eletronicDocument->getSubject()}
                    </a><br>
                    ou acesse<br>
                    <span> <b>Nova Intranet</b> > <b>Área do Usuário</b> > <b>Documento Eletrônico </b> > <b>#{$eletronicDocument->getId()}</b> </span>
                </div>

            </fieldset>";

        return $this;
    }


}