export const AdverseEventsReport = {
            mustReturn: true,
            enterprise: null,
            sector: null,
            event: null,
            complement: { description: null, conduct: null, },
            reporter: { name: null, phonenumber: null, email: null, anonymous: false, },
            patient: { involved: false, name: null, number: null, },
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

export const EmailDefault = {
            email: "anonimo.gampcanoas@gmail.com",
            password: "g4mpcanoas",
            host: "gmail",
            name: "Anônimo",
            anonymous: true
        }

