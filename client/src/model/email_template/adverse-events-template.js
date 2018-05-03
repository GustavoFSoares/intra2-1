export default (report) => {
    
    let email = {}
    email.subject = `Evento Adverso - ${report.event}`
    email.receiver = `gustavo.soares@gampcanoas.com.br`
    email.sender = report.sender

    
    email.body = `
        <fieldset> <legend>Colaborador:</legend>`

    if (report.sender.anonymous) {
        email.body += `
        <b>Este relato foi enviado Anonimamente</b><br>`
    }else{
        email.body += `
            Nome: ${report.sender.name}<br>
            Telefone: ${report.sender.phonenumber}<br>
            E-mail: ${report.sender.email}<br>`
    }


    email.body += `            
        </fieldset><br>

        <fieldset>
            <legend>Local do Evento:</legend>
            Unidade: `+ report.descriptions.enterprise + `<br>`
            if(report.sector){
                email.body += 
                    `Setor: ${report.descriptions.sector} <br>`
            }


    email.body += `
        </fieldset><br>

        <fieldset>
            <legend>Descrição Evento:</legend>
            Evento: ${report.descriptions.event}<br>
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

    if (report.mustReturn && report.sender.anonymous == false) {
        email.body += `<b>Por favor, me responda sobre este E-mail</b><br>`
    }
    
    return email
}