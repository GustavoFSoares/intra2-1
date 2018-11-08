export default class Training {
    constructor(training = { place: '', enterprise: '', room: '' }) {
        this.id = training.id
        this.name = training.name
        this.place = { 
            group: training.enterprise ? { 'enterprise': training.enterprise } : training.enterprise,
            room: training.room
        }
        this.type = training.type
        this.institutionalType = training.institutionalType
        this.instructors = training.instructors ? training.instructors : []
        this.beginTime = training.beginTime ? new Date(training.beginTime.date) : new Date()
        this.endTime = training.endTime ? new Date(training.endTime.date) : new Date()
        this.workload = training.workload
        this.done = training.done ? true : false
    }
}
