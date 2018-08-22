export default class Module {
    constructor(module = {}) {
        this.id = module.id
        this.name = module.name
        this.routeName = module.routeName
        this.icon = module.icon
        this.default = module.default ? true : false
        this.children = module.children
        this.parent = module.parent
    }
}
