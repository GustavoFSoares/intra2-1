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
            ->setSender($report) 
            ->setReceiver($report) 
            ->setBody($report); 
    }

    public function setSubject($report) {
        $this->subject = "Evento Adverso - {$report->event['description']}";

        return $this;
    }
    
    public function setSender($report) {
        $this->sender = $report->sender;
        
        return $this;
    }

    public function setReceiver($report) {
        if ($report->enterprise['id'] == 'hpsc') {
            $this->receiver = "eventoadverso.hpsc@gampcanoas.com.br";
        } else {
            $this->receiver = "eventoadverso.hu@gampcanoas.com.br";
        }

        return $this;
    }

    public function setBody($report) {
        $this->body = "
            <fieldset> 
                <legend>Colaborador:</legend>";

            if ($report->reporter['anonymous']) {
                $this->body .= "
                        <b>Este relato foi enviado Anonimamente</b><br>";
            } else {
                $this->body .= "
                        Nome: {$report->reporter['name']} <br>
                        Telefone: {$report->reporter['phonenumber']}<br>
                        E-mail: {$report->reporter['email']}<br>";
            }

        $this->body .= "
            </fieldset><br>

            <fieldset>
                <legend>Local do Evento:</legend>
                    Unidade: {$report->enterprise['name']}<br>";
            if ($report->sector) {
                $this->body .= "
                        Setor: {$report->sector['name']}<br>";
            }

        $this->body .= "
            </fieldset><br>
        
            <fieldset>
                <legend>Descrição Evento:</legend>
                    Evento: {$report->event['description']}<br>
                    Horário do Ocorrido: {$report->eventTime}<br>
                    Descrição: {$report->complement['description']}<br>
                    Coonduta Aplicada: {$report->complement['conduct']}<br>
                    
                    <br>

                    <fieldset>
                        <legend>Paciente Envolvido:</legend>";
                    if (!$report->patient['involved']) {
                        $this->body .= "
                            <b>Não houve problemas com paciente</b><br>";
                    } else {
                        $this->body .= "
                            Nome: {$report->patient['name']}<br>
                            Número do Atendimento: {$report->patient['number']}<br>";
                    }
                $this->body .= "
                    </fieldset>
            </fieldset>
                    
        <br>";

        if ($report->mustReturn && $report->reporter['anonymous'] == false) {
            $this->body .= "<b>Por favor, me responda sobre este E-mail</b><br>";
        }

        return $this;
    }


}