<?php
namespace HospitalApi\Template;

/**
 * <b>IncidentReportingEmailTemplate</b>
 */
class IncidentReportingNoticicationEmailTemplate extends EmailTemplateAbstract
{

    public function __construct($report, $userSender, $userReceiver) {
        $this
            ->setSubject($report)
            ->setSender(null)
            ->setReceiver($userReceiver->getEmail())
            ->setBody($report, ['sender'=>$userSender, 'receiver'=>$userReceiver]);
    }

    public function setSender($sebder) {
        $sender = $this->getEmailDefault();
        $sender['name'] = 'GAMP - Qualidade e Segurança (Incidentes)';

        $this->sender = $sender;
        return $this;
    }

    public function setSubject($report) {
        $this->subject = "#{$report->getId()} Notificação de Incidente - {$report->getEvent()->getDescription()}";

        return $this;
    }
    
    public function setBody($report, $user) {
        $this->body = "
            <h2>#{$report->getId()} Notificação de Incidente - {$report->getEvent()->getDescription()}</h2>

            Prezado {$user['receiver']->getName()},
            <br><br>
            <b>{$user['sender']->getName()} (<i>{$user['sender']->getGroup()->getName()}</i>)</b> enviou uma nova mensagem no acompanhamento do incidente.

            <fieldset> 
                <div style='text-align: center'>
                    <a href=http://{$_SERVER['SERVER_NAME']}:8080/usuario/notificacao-de-incidentes/detalhe/{$report->getId()}>
                        #{$report->getId()} Notificação de Incidente - {$report->getEvent()->getDescription()}
                    </a><br>
                    ou acesse<br>
                    <span> <b>Nova Intranet</b> > <b>Área do Usuário</b> > <b>Notificação de Incidente </b> > <b>#\"Identificador do Evento\"</b> </span>
                </div>

            </fieldset>";
        
        return $this;
    }


}