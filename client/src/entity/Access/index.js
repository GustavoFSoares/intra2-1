export default class Access {
        constructor() {
            this.id = null
            this.path = ''
            this.permissions = [ ]
        }
        
        isValid() {
            if(this.permissions['group'] != undefined) {
                return false
            } else if(this.permissions['admin'] != undefined) {
                return false
            } else if(this.permissions['level'] != undefined) {
                return false
            }
            return true
        }
}
