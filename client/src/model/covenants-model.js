import service from "@/services/covenants"

const getters = {
    getCovenants: () => service.getCovenants(),
    getCovenantById: (id) => service.getCovenants(id),
}

const model = {
    doAddCovenant: (data) => service.addCovenant(data),
    doEditCovenant: (id, data) => service.editCovenant(id, data),
    doChangeStatusCovenant: (id) => service.changeStatusCovenant(id),
    doDeleteCovenant: (id) => service.deleteCovenant(id),

    isEdit: (id) => id ? true : false
}

export default model
export const getter = getters

