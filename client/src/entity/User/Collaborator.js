import User from '.';

export default class Collaborator extends User {
    constructor(collaborator = null) {
        if(!collaborator) {
            collaborator = { complement: { } }
        }
        super(collaborator)
        this.id = collaborator.id ? collaborator.id : '0'
        this.complement = {
            hire: collaborator.complement.hire,
            fire: collaborator.complement.fire,
            turn: collaborator.complement.turn,
            type: collaborator.complement.type,
            entity: collaborator.complement.entity,
        }



        
        
    }

}