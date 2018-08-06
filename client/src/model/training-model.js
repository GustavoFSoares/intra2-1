import service from "@/services/training"
import serviceGroup from "@/services/group"
import serviceTraining from "@/services/training"
import serviceUser from "@/services/user"

const getters = {
    getEnterprises: () => serviceGroup.getEnterprises(),
    getUsers: () => serviceUser.getUsers(),
    getUserById: (id) => serviceUser.getUsers(id),
    getTrainings: () => service.getTrainings(),
    getTrainingById: (id) => service.getTrainings(id),
    getTrainingsType: () => serviceTraining.getTrainingsType(),
    getParticipantsTraining: (trainingId) => serviceTraining.getParticipantsTraining(trainingId),
}

const model = {
    doInsert: (data) => service.doInsert(data),
    addParticipants: (trainingId, data) => service.addParticipants(trainingId, data),
    isEdit(id) {
        if(id) {
            return true
        }
        return false
    },
    doUpdate: (id, data) => service.doUpdate(id, data),
    doDelete: (id) => service.doDelete(id),
    indexOf: (users, user) => {
        let ok
        users.forEach((u, index) => {
            if (u.id == user.id) {
                ok = index
            }
        })
        return ok
    }
}

export default model
export const getter = getters