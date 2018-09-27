export default class User {
        constructor(user = null) {
            if(!user){
                user = { group: { name: '', enterprise: '' } }
            }
            this.id = user.id
            this.code = user.code
            this.name = user.name
            this.email = user.email
            this.group = user.group
            this.level = user.level
            this.admin = user.admin = user.admin ? true : false
            this.ramal = user.ramal
            this.occupation = user.occupation
            this.c_removed = user.c_removed
        }
}
