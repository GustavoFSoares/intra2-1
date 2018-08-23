import service from "@/services/modules"
import serviceGroup from "@/services/group"

const getters = {
    getModules: () => service.getModules(),
    getModuleById: (id) => service.getModules(id),

    getGroups: () => serviceGroup.getGroups(),

    getModulesByGroup: (group) => service.getModulesByGroup(group),
}

const model = {
    doPermissionForGroup: (data) => {
        alert('Salvo')
        return service.doPermission(data).then(res => '')
    },
    
    doAddModule: (data) => service.addModule(data),
    doEditModule: (id, data) => service.editModule(id, data),
    doAddChieldModule: (data) => service.addChieldModule(data),
    doEditChieldModule: (id, data) => service.editChieldModule(id, data),
    doChangeStatusModule: (id) => service.changeStatusModule(id),
    doDeleteModule: (id) => service.deleteModule(id),
    doRemoveChieldModule: (id) => service.removeChield(id),
    
    isEdit: (id) => id ? true : false
}

export default model
export const getter = getters