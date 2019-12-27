export default class Sector {
    constructor(sector = { active: true }) {
        this.id = sector.id
        this.name = sector.name
        this.enterprise = sector.enterprise
        this.c_removed = sector.c_removed ? true : false
        this.c_modified= sector.c_modified
        this.c_created= sector.c_created
    }
}
