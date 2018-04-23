import { sendMail } from "@/services/adverse-events";
export const getSectorsHu = () => {
    return [
        { text:'Almoxarifado', value:'almoxarifado' },
        { text:'CAPS - Amanhecer', value:'caps-amanhecer' }
    ]
    return sectors;
}

export const getSectorsHpsc = () => {
    return [
        { text: 'Administração', value: 'administracao' },
        { text: 'CTI Adulto', value: 'cti-adulto' }
    ]
}

export const getEnterprises = () => {
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

export const getEvents = () => {
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

export const sendData = (mail) => {
    
    console.log(mail);
    
    mail = {
        "body": "Corpo Email 123",
        "subject": "Assunto 123",
        "receiver": "gustavo.soares@gampcanoas.com.br",
        "sender": {
            "mail": "gustavo.soares@gampcanoas.com.br",
            "password": "Gustavo726",
            "name": "Gustavo Soares"
        }
    }

    // mustReturn: true,
    // unit: 'hu', X
    // sector: 'ti',X
    //     event: 'ab', X
    //     complement: { description: 'Descrição Aqui', conduct: 'Conduta Aqui', }, X
    //     person: { name: 'Gustavo', phonenumber: '984700974', mail: 'email@email.com', }, X
    //     patient: { involved: true, name: "Joao", number: "123", }, X

    //enviar informações para rota, direto para banco,
    //com rota separada para email

    //mudar de seTor para seCtor
    // return sendMail(mail)
}

const verifyEmail = (sender) => {

}