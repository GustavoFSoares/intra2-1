export default class User {
        constructor(user = null) {
            if(!user){
                user = { }
            }
            this.id = user.id
            this.name = user.name
            this.group = user.group
            this.level = user.level
            this.admin = user.admin
        }        
}
