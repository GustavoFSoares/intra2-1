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

export const getUnits = () => {
    return [
        { text: 'Hospital Universitário - HU', value: 'hu' },
        { text: 'Hospital Pronto Socorro - HPSC', value: 'hpsc' } 
    ]
}

export const getEvents = () => {
    return [
        { text: 'Drepressão Pós-Almoço', value: 'dpa', selected: '' },
        { text: 'Fome Excessiva Compulsiva', value: 'fm', selected: '' } 
    ]
}

export const buildMail = (mail) => {
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

    return sendMail(mail)
}