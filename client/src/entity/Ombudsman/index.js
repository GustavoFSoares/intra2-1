const OmbudsmanUser = require('./OmbudsmanUser').default
export default class Ombudsman {
    constructor(ombudsman = { group: '', ombudsman: '', registerTime: '', ombudsmanUser: new OmbudsmanUser(), origin: { } }) {
        this.id = ombudsman.id
        this.ombudsmanUser = new OmbudsmanUser(ombudsman.ombudsmanUser)
        this.ombudsmanUserDescription = ombudsman.ombudsmanUserDescription
        this.ombudsmanUserSugestion = ombudsman.ombudsmanUserSugestion
        this.ombudsman = ombudsman.ombudsman
        this.ombudsmanDescription = ombudsman.ombudsmanDescription
        
        this.manager = ombudsman.manager
        this.managerResponse = ombudsman.managerResponse
        
        this.origin = ombudsman.origin
        this.demands = ombudsman.demands ? ombudsman.demands : []
        this.type = ombudsman.type

        this.bed = ombudsman.bed
        this.group = ombudsman.group
        
        this.ombudsmanToResponse = ombudsman.ombudsmanToResponse
        this.responseToUser = ombudsman.responseToUser
        this.registerTime = ombudsman.registerTime ? ombudsman.registerTime : new Date()
        this.reported = ombudsman.reported ? true : false
        this.answered = ombudsman.answered ? true : false
        this.status = ombudsman.status
        this.relevance = ombudsman.relevance
        this.reportedBy = ombudsman.reportedBy
    }
}
