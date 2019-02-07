<?php
namespace HospitalApi\Template;
use HospitalApi\Entity\EletronicDocument;
use HospitalApi\Entity\User;

/**
 * <b>EletronicDocumentSignatureRevokedEmailTemplate</b>
 * Contem o template padrão do email de Documento Eletrônico referente a assinatura
 */
class EletronicDocumentSignatureRevokedEmailTemplate extends EletronicDocumentSignatureEmailTemplate {

    public function __construct(EletronicDocument $eletronicDocument, $user, $rason) {

        $this
            ->setSubject($eletronicDocument) 
            ->setSender($eletronicDocument->getId()) 
            ->setReceiver($user) 
            ->setBody($eletronicDocument, ['user'=> $user, 'rason' => $rason]); 
    }

    public function setSubject($eletronicDocument) {
        $this->subject = "Indeferido - Protoco {$eletronicDocument->getId()} - Documento Eletrônico - {$eletronicDocument->getSubject()}";

        return $this;
    }
    
    public function setBody($eletronicDocument, $userRason) {
        $user = $userRason['user'];
        $rason = $userRason['rason'];

        $this->body = 
            "<h2>Documento {$eletronicDocument->getId()}</h2>

            Prezado {$eletronicDocument->getUser()->getName()},
            <br><br>
            O sr. <b>{$user->getName()} (<i>{$user->getGroup()->getName()}</i>)</b> rejeitou o documento com a seguinte justificativa:
            <div>
                <p style='margin-left: 5%'>
                    $rason
                </p>
            </div>

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