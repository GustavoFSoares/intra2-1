export default class Ombudsman {
    constructor(ombudsman = { group: '', ombudsman: '', registerTime: '', ombudsmanUser: {}, }) {
        this.id = ombudsman.id
        this.bed = ombudsman.bed
        this.description = ombudsman.description
        this.group = ombudsman.group
        this.ombudsman = ombudsman.ombudsman
        this.ombudsmanDescription = ombudsman.ombudsmanDescription
        this.ombudsmanUser = ombudsman.ombudsmanUser
        this.origin = ombudsman.origin
        this.registerTime = ombudsman.registerTime
        this.reported = ombudsman.reported
        this.sugestion = ombudsman.sugestion
        this.type = ombudsman.type
    }
}
