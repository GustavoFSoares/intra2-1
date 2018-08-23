import service from "@/services/user"

const getters = {
    getUsers: () => service.getUsers(),
    getUserById: (id) => service.getUsers(id),
    getUsersByGroupId: (groupId) => service.getUsersByGroupId(groupId),
}

const model = {
    doEditUser: (id, data) => service.editUser(id, data),
}

export default model
export const getter = getters