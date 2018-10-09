export default class Ramal {
    constructor(ramal = null) {
        if (!ramal) {
            ramal = { }
        }
        this.id = ramal.id
        this.group = ramal.group
        this.number = ramal.number
        this.floor = ramal.floor
        this.core= ramal.core
        this.active= ramal.active
    }
}
