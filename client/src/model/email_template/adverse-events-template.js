export default (report) => {
    
    let email = {}
    email.subject = `Evento Adverso - ${report.event.description}`
    email.receiver = `gustavo.soares@gampcanoas.com.br`
    email.sender = report.sender
    
    
    email.body = `
        <fieldset> <legend>Colaborador:</legend>`

    if (report.reporter.anonymous) {
        email.body += `
        <b>Este relato foi enviado Anonimamente</b><br>`
    }else{
        email.body += `
            Nome: ${report.reporter.name}<br>
            Telefone: ${report.reporter.phonenumber}<br>
            E-mail: ${report.reporter.email}<br>`
    }


    email.body += `            
        </fieldset><br>

        <fieldset>
            <legend>Local do Evento:</legend>
            Unidade: ${report.enterprise.name}<br>`
            if(report.sector){
                email.body += 
                    `Setor: ${report.sector.name} <br>`
            }


    email.body += `
        </fieldset><br>

        <fieldset>
            <legend>Descrição Evento:</legend>
            Evento: ${report.event.description}<br>
            Descrição: ${report.complement.description}<br>
            Coonduta Aplicada: ${report.complement.conduct}<br>
               
            <br>

            <fieldset>
                <legend>Paciente Envolvido:</legend>`
                if (!report.patient.involved) {
                    email.body += `
                        <b>Não houve problemas com paciente</b><br>`
                } else {
                    email.body += `
                        Nome: ${report.patient.name}<br>
                        Número do Atendimento: ${report.patient.number}<br>`
                }
    email.body += `
            </fieldset>
        </fieldset>
                
        <br>`

    if (report.mustReturn && report.reporter.anonymous == false) {
        email.body += `<b>Por favor, me responda sobre este E-mail</b><br>`
    }
    
    return email
}