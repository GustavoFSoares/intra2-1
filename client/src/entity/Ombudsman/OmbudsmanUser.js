export default class OmbudsmanUser {
    constructor(ombudsmanUser = { }) {
        this.patientName = ombudsmanUser.patientName
        this.birthday = ombudsmanUser.birthday
        this.phoneNumber = ombudsmanUser.phoneNumber
        this.declarantName = ombudsmanUser.declarantName
        this.email = ombudsmanUser.email 
    }
}