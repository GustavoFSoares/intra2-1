import { sendMail } from "@/services/adverse-events";
import { EmailDefault } from "../entity";

const getSectorsHu = () => {
    return [
        { text:'Almoxarifado', value:'almoxarifado' },
        { text:'CAPS - Amanhecer', value:'caps-amanhecer' }
    ]
    return sectors;
}

const getSectorsHpsc = () => {
    return [
        { text: 'Administração', value: 'administracao' },
        { text: 'CTI Adulto', value: 'cti-adulto' }
    ]
}

const getEnterprises = () => {
    return [
        { text: 'Hospital Universitário - HU', value: 'hu' },
        { text: 'Hospital Pronto Socorro - HPSC', value: 'hpsc' },
        { text: 'CAPS - Amanhecer', value: 'caps-amanhecer' },
        { text: 'CAPS - Novo Tempo', value: 'caps-novo-tempo' },
        { text: 'CAPS - Recanto dos Girassóis', value: 'caps-recanto-dos-girassóis' },
        { text: 'CAPS - Travessia', value: 'caps-travessia' },
        { text: 'UPA - Caçapava', value: 'upa-cacapava' },
        { text: 'UPA - Rio Branco', value: 'upa-riopBranco' },
    ]
}

const getEvents = () => {
    return [
        { text: 'Desenvolvimento de Lesão por Pressão(UP)', value: 'dpa', selected: '' },
        { text: 'Erro de Medicação (medicamento errado, paciente errado, medicação não administrada)', value: 'fm', selected: '' },
        { text: 'Erro de Processo (Paciente deixa de realizar exames e/ou cirurgia)', value: 'fm', selected: '' },
        { text: 'Falha na Administração de Dietas (Administrada diferente do prescrito, contaminada)', value: 'fm', selected: '' },
        { text: 'Falha na Identificação do Paciente', value: 'fm', selected: '' },
        { text: 'Flebite', value: 'fm', selected: '' },
        { text: 'Fuga do paciente', value: 'fm', selected: '' },
        { text: 'Hidratação não administrada', value: 'fm', selected: '' },
        { text: 'Infecção hospitalar', value: 'fm', selected: '' },
        { text: 'Morte inesperada', value: 'fm', selected: '' },
        { text: 'Óbito intra-operatório ou pós-hoperatório imediato (paciente eletivos ou com baixo risco cirúrgico', value: 'fm', selected: '' },
        { text: 'PCR inesperado', value: 'fm', selected: '' },
        { text: 'Procedimento cirúrgico no lado errado do corpo', value: 'fm', selected: '' },
        { text: 'Procedimento cirúrgico no paciente errado', value: 'fm', selected: '' },
        { text: 'Queda', value: 'fm', selected: '' },
        { text: 'Queixa técnica (Produto/Medicação)', value: 'fm', selected: '' },
        { text: 'Reação medicamentosa', value: 'fm', selected: '' },
        { text: 'Reação transfuncional ou imediatamente após transfusão de hemecomponentes', value: 'fm', selected: '' },
        { text: 'Rótulo mal preenchido, incompleto ou incorreto', value: 'fm', selected: '' },
        { text: 'Outros', value: 'fm', selected: '' },
    ]
}

const sendData = (report) => {
    
    report.sender = verifyEmail(report.sender)
    report = buildEmail(report)
    
    return sendMail(report)
}

const verifyEmail = (sender) => {
    if(sender.anonymous) {
        return EmailDefault
    } else {
        return sender
    }
}

const buildEmail = (report) => {
    let email = { }
    email.subject = `Evento Adverso - ${report.event}`
    email.receiver = `gustavo.soares@gampcanoas.com.br`
    email.sender = report.sender
    
    email.body = `
        <fieldset> <legend>Colaborador:</legend>`
    
        if (report.sender.anonymous){
            email.body += `<b>Este relato foi enviado anonimamente</b><br>`
        }
    
        
    email.body += `
            Nome: ${report.sender.name}<br>
            Telefone: ${report.sender.phonenumber}<br>
            E-mail: ${report.sender.mail}<br>
        </fieldset><br>

        <fieldset>
            <legend>Local do Evento:</legend>
            Unidade: ${report.enterprise}<br>
            Setor: ${report.setor}<br>
        </fieldset><br>

        <fieldset>
            <legend>Descrição Evento:</legend>
            Evento: ${report.event}<br>
            Descrição: ${report.complement.description}<br>
            Coonduta Aplicada: ${report.complement.conduct}<br>
               
            <br>

            <fieldset>
                <legend>Paciente Envolvido:</legend>`
                if(!report.patient.involved){
                    email.body += `<b>Não houve problemas com paciente</b><br>`
                }
    
    email.body += `
                Nome: ${report.patient.nome}<br>
                Número do Atendimento: ${report.patient.number}<br>
            </fieldset>
        </fieldset>

        <br>`
        if(report.mustReturn){
            email.body += `<b>Por favor, me responda sobre este email</b><br>`
        }

    return email
}

export default {
    sendData,
    getEvents,
    getEnterprises,
    getSectorsHpsc,
    getSectorsHu,
}