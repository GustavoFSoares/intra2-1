import service from "@/services/training"
import serviceGroup from "@/services/group"
import serviceUser from "@/services/user"

const getters = {
    getEnterprises: () => serviceGroup.getEnterprises(),
    getUsers: () => serviceUser.getUsers()
}

const model = {
    // doPermissionForGroup: (data) => {
    //     alert('Salvo')
    //     return service.doPermission(data).then(res => '')
    // },

    // doAddModule: (data) => service.addModule(data),
    // doEditModule: (id, data) => service.editModule(id, data),
    // doChangeStatusModule: (id) => service.changeStatusModule(id),
    // doDeleteModule: (id) => service.deleteModule(id),

    // isEdit: (id) => id ? true : false
}

export default model
export const getter = getters