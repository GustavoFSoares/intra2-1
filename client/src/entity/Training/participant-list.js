export default class ParticipantList {
    constructor(participant = {}) {
        this.id = participant.id
        this.name = participant.name
        this.code = participant.code
        this.student = participant.student
        this.occupation = participant.occupation
        this.GroupId = participant.group.id
        this.GroupName = participant.group.name
        this.GroupIdName = participant.group.groupId
        this.presence = participant.presence ? participant.presence : true
        this.isAdded = participant.isAdded ? true : false
    }
}
