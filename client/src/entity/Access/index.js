export default class Access {
        constructor() {
            this.id = null
            this.path = ''
            this.permissions = {
                group: true,
                admin: true,
                level: true,
            }
        }
        
        isValid() {
            if(!this.permissions.group) {
                return false
            } else if(!this.permissions.admin) {
                return false
            } else if(!this.permissions.level) {
                return false
            }
            return true
        }
}
