export default class {
    constructor(){
        this.type = ''
        this.text = ''
    }
}

export const Mail = {
            success: {
                type: "success",
                text: "Email enviado com Sucesso"
            },
            failed: {
                type: "danger",
                text: "Email não pode ser enviado. Por favor tente novamente"
            },
            warning: {
                type: "warning",
                text: "ATENÇÃO! - "
            }
        }

export const LoginStatus = {
            success: {
                type: "success",
                text: "Usuário Autenticado"
            },
            failed: {
                type: "danger",
                text: ""
            },
            warning: {
                type: "warning",
                text: "ATENÇÃO! - "
            }
        }