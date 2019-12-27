import service from "@/services/sectors"

const getters = {
    getSectors: () => service.getSectors(),
    getSectorsActive: () => service.getSectors({ 'active': 1 }),
    getSectorById: (id) => service.getSectors({ 'id': id }),
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
}

export const getter = getters
export default model