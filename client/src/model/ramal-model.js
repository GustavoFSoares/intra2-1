import service from "@/services/ramals"
import serviceGroup from "@/services/group"

const getters = {
    getAllRamals: () => service.getAllRamals(),
    getRamals: () => service.getRamals(),
    getRamalById: (id) => service.getRamals(id),
    getGroups: () => serviceGroup.getGroups(),
    getGroupById: (id) => serviceGroup.getGroups(id),
}

const model = {
    doInsert: (data) => service.doInsert(data),
    isEdit(id) {
        if (id) {
            return true
        }
        return false
    },
    doUpdate: (id, data) => service.doUpdate(id, data),
    doDelete: (id) => service.doDelete(id),
    doUnactive: (id) => service.doUnactive(id),
}

export const getter = getters
export default model