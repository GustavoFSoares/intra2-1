<?php
namespace HospitalApi\Template;
use HospitalApi\Entity\EletronicDocumentAmendment;
use HospitalApi\Entity\User;

/**
 * <b>EletronicDocumentSignatureToAmendmentEmailTemplate</b>
 * Contem o template padrão do email de Documento Eletrônico referente a assinatura
 */
class EletronicDocumentSignatureToAmendmentEmailTemplate extends EletronicDocumentSignatureEmailTemplate {

    public function __construct(EletronicDocumentAmendment $amendment, User $nextUser) {
        $this
            ->setSubject($amendment->getDocument()) 
            ->setSender($amendment->getDocument()->getId()) 
            ->setReceiver($nextUser) 
            ->setBody($amendment, $nextUser); 
    }

    public function setSubject($eletronicDocument) {
        $this->subject = "Reavaliar - Protoco {$eletronicDocument->getId()} - Documento Eletrônico - {$eletronicDocument->getSubject()}";

        return $this;
    }
    
    public function setBody($amendment, $nextUser) {
        $this->body = 
            "<h2>Documento {$amendment->getDocument()->getId()}</h2>

            Prezado {$nextUser->getName()},
            <br><br>
            O sr. <b>{$amendment->getUser()->getName()} (<i>{$amendment->getUser()->getGroup()->getName()}</i>)</b> solicitou que reavalie um documento.

            <fieldset> 
                <div style='text-align: center'>
                    <a href=http://{$_SERVER['SERVER_NAME']}:8080/usuario/documentos-eletronicos/detalhe/{$amendment->getDocument()->getId()}>
                        Protocolo <b>{$amendment->getDocument()->getId()}</b> Documento Eletronico - {$amendment->getDocument()->getSubject()}
                    </a><br>
                    ou acesse<br>
                    <span> <b>Nova Intranet</b> > <b>Área do Usuário</b> > <b>Documento Eletrônico </b> > <b>#{$amendment->getDocument()->getId()}</b> </span>
                </div>

            </fieldset>";

        return $this;
    }
}