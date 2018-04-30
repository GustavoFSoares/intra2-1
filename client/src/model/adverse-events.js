import services from "@/services/adverse-events";
import { EmailDefault } from "../entity";



const getSectorsBy = (id) => services.getSectorsBy(id)
const getEnterprises = () => services.getEnterprises()
const getEvents = () => services.getEvents()

const sendData = (report) => {
    
    report.sender = verifyEmail(report.sender)
    services.saveData(report)
    
    report = buildEmail(report)
    return services.sendMail(report)
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
                } else {

                    email.body += `
                        Nome: ${report.patient.nome}<br>
                        Número do Atendimento: ${report.patient.number}<br>`
                }
        email.body += `
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
    getSectorsBy,
}