export const AdverseEventsReport = {
            mustReturn: false,
            enterprise: null,
            sector: null,
            event: null,
            complement: { description: null, conduct: null, },
            sender: { name: null, phonenumber: null, email: null, password: null, anonymous: false, host: 'office365' },
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
            }
        }

export const EmailDefault = {
            email: "anonimo.gampcanoas@gmail.com",
            password: "g4mpcanoas",
            host: "gmail",
            name: "Anônimo",
            anonymous: true
        }

