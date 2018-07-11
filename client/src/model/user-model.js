import service from "@/services/user"
import User from '@/entity/User'

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