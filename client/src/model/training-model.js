import service from "@/services/training"
import serviceGroup from "@/services/group"
import serviceTraining from "@/services/training"
import serviceUser from "@/services/user"

const getters = {
    getEnterprises: () => serviceGroup.getEnterprises(),
    getUsers: () => serviceUser.getUsers(),
    getTrainings: () => service.getTrainings(),
    getTrainingById: (id) => service.getTrainings(id),
    getTrainingsType: () => serviceTraining.getTrainingsType(),
}

const model = {
    doInsert: (data) => service.doInsert(data),
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
            if (u.code == user.code) {
                ok = index
            }
        })
        return ok
    }
}

export default model
export const getter = getters