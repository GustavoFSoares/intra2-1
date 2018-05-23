export default class Alert {
        constructor() {
            this.title = '',
            this.description = '',
            this.type = ''
        }
}

const getOptions = () => [
    { name: "Erro", value: "danger" },
    { name: "Aviso", value: "warning" },
]

const getSelectedOption = (type) => {  
    let exp = new RegExp(type, 'i')
    let option = options().filter(option => exp.test(option.value))
    return option[0];
}

export const alertEntity = {
    getSelectedOption,
    getOptions,
}