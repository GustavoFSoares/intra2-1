export const getSectorsHu = () => {
    return [
        { text:'Almoxarifado', value:'almoxarifado' },
        { text:'CAPS - Amanhecer', value:'caps-amanhecer' }
    ]
    return sectors;
}

export const getSectorHpsc = () => {
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