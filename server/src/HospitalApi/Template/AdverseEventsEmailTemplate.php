<?php
namespace HospitalApi\Template;

/**
 * <b>AdverseEventsEmailTemplate
 * Contem o template padrão do email de Eventos Adversso
 */
class AdverseEventsEmailTemplate extends EmailTemplateAbstract
{

    public function __construct($report) {
        $this
            ->setSubject($report) 
            ->setSender(null) 
            ->setReceiver($report->getFailedPlace()) 
            ->setBody($report, $this->getSender()['email']); 
    }

    public function setSubject($report) {
        $this->subject = "#{$report->getId()} - Notificação de Incidente - {$report->getEvent()->getDescription()}";

        return $this;
    }
    
    public function setSender($sender) {
        $sender = $this->getEmailDefault();
        $sender['name'] = 'GAMP - Qualidade e Segurança (Incidentes)';

        $this->sender = $sender;
        
        return $this;
    }

    public function setReceiver($failedPlace) {
        if($failedPlace->getEnterprise() == 'HPSC') {
            $receiverEmail = "eventoadverso.hpsc@gampcanoas.com.br";
        } else {
            $receiverEmail = "eventoadverso.hu@gampcanoas.com.br";
        }
        parent::setReceiver($receiverEmail);
        
        return $this;
    }

    public function setBody($report, $writer) {
        $this->body = "
            <h2>#{$report->getId()} - Notificação de Incidente - {$report->getEvent()->getDescription()}</h2>
            <fieldset> 
                <legend>Colaborador:</legend>";

            if ($report->getReporterEmail()) {
                $this->body .= "
                    E-mail: {$report->getReporterEmail()}<br>";
            } else {
                $this->body .= "
                    <b>Este relato foi enviado Anonimamente</b><br>";
            }

        $this->body .= "
            </fieldset><br>

            <fieldset>
                <legend>Local do Evento:</legend>
                    Local de quem relatou o evento: {$report->getReportPlace()->getName()}<br>
                    Local onde ocorreu a falha: {$report->getFailedPlace()->getName()}<br>";

        $this->body .= "
            </fieldset><br>
        
            <fieldset>
                <legend>Descrição Evento:</legend>
                    Evento: {$report->getEvent()->getDescription()}<br>
                    Horário que ocorreu a falha: {$report->getFailedTime()->format('d/m/Y H:i')}<br>
                    Horário que foi feito o relato: {$report->getRecordTime()->format('d/m/Y H:i')}<br>
                    Descrição: {$report->getDescription()}<br>
                    Coonduta Aplicada: {$report->getConduct()}<br>
                    
                    <br>

                    <fieldset>
                        <legend>Paciente Envolvido:</legend>";
                    if (!$report->getPatientInvolved()) {
                        $this->body .= "
                            <b>Não houve problemas com paciente</b><br>";
                    } else {
                        $this->body .= "
                            Nome: {$report->getPatient()['name']}<br>
                            Número do Atendimento: {$report->getPatient()['id']}<br>";
                    }
                $this->body .= "
                    </fieldset>
            </fieldset>
                    
        <br>";

        if ($report->getMustReturn() && $report->getReporterEmail()) {
            $this->body .= "<b>Por favor, me responda sobre este E-mail</b><br>";
        }

        return $this;
    }


}