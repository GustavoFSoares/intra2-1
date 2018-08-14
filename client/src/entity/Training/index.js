export default class Training {
    constructor(training = {}) {
        this.id = training.id
        this.name = training.name
        this.place = training.place
        this.type = training.type
        this.institutionalType = training.institutionalType
        this.instructor = training.instructor
        this.timeTraining = training.timeTraining
        this.workload = training.workload
        this.done = training.done ? true : false
    }
}
