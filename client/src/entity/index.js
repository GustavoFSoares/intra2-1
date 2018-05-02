export const AdverseEventsReport = {
            mustReturn: false,
            enterprise: '',
            sector: '',
            event: '',
            complement: { description: '', conduct: '', },
            sender: { name: '', phonenumber: '', email: '', password: '', anonymous: false, host: 'office365' },
            patient: { involved: true, name: "", number: "", },
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

