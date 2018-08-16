export default class User {
        constructor(user = null) {
            if(!user){
                user = { group: { name: '', enterprise: '' } }
            }
            this.id = user.id
            this.code = user.code
            this.name = user.name
            this.group = user.group
            this.level = user.level
            this.admin = user.admin
            this.ramal = user.ramal
            this.student = user.student
            this.occupation = user.occupation
            this.c_removed = user.c_removed
            this.hire = user.hire
            this.fire = user.fire
            this.turn = user.turn
        }
}
