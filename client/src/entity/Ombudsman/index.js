const OmbudsmanUser = require('./OmbudsmanUser').default
export default class Ombudsman {
    constructor(ombudsman = { group: '', ombudsman: '', registerTime: '', ombudsmanUser: new OmbudsmanUser(), }) {
        this.id = ombudsman.id
        this.bed = ombudsman.bed // *
        this.description = ombudsman.description
        this.demands = []
        this.group = ombudsman.group // *
        this.ombudsman = ombudsman.ombudsman ? ombudsman.ombudsman : window.$session.get('user')
        this.ombudsmanDescription = ombudsman.ombudsmanDescription
        this.ombudsmanUser = ombudsman.ombudsmanUser ? ombudsman.ombudsmanUser : new OmbudsmanUser()
        this.origin = ombudsman.origin
        this.registerTime = ombudsman.registerTime
        this.reported = ombudsman.reported ? true : false
        this.sugestion = ombudsman.sugestion
        this.type = ombudsman.type
    }
}
