export default class {
    constructor(alert = {}){
        this.type = alert.type
        this.text = alert.message
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