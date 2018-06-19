export class AdverseEventsReport {
            constructor() {
                this.mustReturn = false
                this.enterprise = null
                this.sector = null
                this.event = null
                this.eventTime = null
                this.complement = { description: null, conduct: null, }
                this.reporter = { name: null, phonenumber: null, email: null, anonymous: false, }
                this.patient = { involved: false, name: null, number: null, }
            }

        }

export class EmailDefault {
            constructor() {
                this.email = "anonimo.gampcanoas@gmail.com"
                this.password = "g4mpcanoas"
                this.host = "gmail"
                this.name = "Anônimo"
                this.anonymous = true
            }

        }

