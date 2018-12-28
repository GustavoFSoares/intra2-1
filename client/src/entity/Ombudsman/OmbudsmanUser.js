const moment = require('moment')
export default class OmbudsmanUser {
    constructor(ombudsmanUser = { }) {
        this.id = ombudsmanUser.id
        this.address = ombudsmanUser.address
        this.patientName = ombudsmanUser.patientName
        this.birthday = ombudsmanUser.birthday ? moment(ombudsmanUser.birthday.date).format('DD/MM/YYYY') : ""
        this.phoneNumber = ombudsmanUser.phoneNumber
        this.declarantName = ombudsmanUser.declarantName
        this.email = ombudsmanUser.email
    }
}