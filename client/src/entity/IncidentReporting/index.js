export default class IncidentReporting {
    constructor(incidentReporting = {}) {
        this.id = incidentReporting.id
        this.place = {
            reportPlace: incidentReporting.reportPlace ? incidentReporting.reportPlace : "",
            failedPlace: incidentReporting.failedPlace ? incidentReporting.failedPlace : "",
        }
        this.event = incidentReporting.event ? incidentReporting.event : ""
        this.description = incidentReporting.description
        this.conduct = incidentReporting.conduct
        this.mustReturn = incidentReporting.mustReturn ? true : false
        this.reporterEmail = incidentReporting.reporterEmail
        this.patient = {
            involved: incidentReporting.patientInvolved ? true : false,
            id: incidentReporting.patientId,
            name: incidentReporting.patientName,
        }
        this.recordTime = incidentReporting.recordTime
        this.failedTime = incidentReporting.failedTime
        this.filtered = incidentReporting.filtered ? true : false
        this.closed = incidentReporting.closed ? true : false
        this.transmissionList = incidentReporting.transmissionList ? incidentReporting.transmissionList : []
    }

}