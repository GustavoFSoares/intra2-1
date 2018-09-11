import service from "@/services/user"
import User from "@/entity/User";

const getters = {
    getUsers: () => service.getUsers(),
    getUserById: (id) => service.getUsers({ 'id':id }),
    getUsersByGroupId: (groupId) => service.getUsers({ 'group':groupId, 'c_removed':0 }),
    getUsersActivedByGroupId: (groupId) => service.getUsers({ 'group':groupId }),
    getUsersAdminByGroup: (groupId) => service.getUsers({ 'group':groupId, 'admin':1 }),
}

const model = {
    doEditUser: (id, data) => service.editUser(id, data),
    doEditUsers: (data) => service.editUsers(data),
    loadUsers: (groupId) => new Promise(resolve => {
        getter.getUsersAdminByGroup(groupId).then(res => {
            let users = []
            res.forEach(user => {
                users.push(new User(user))
            })
            resolve(users)
        })
    })
}

export default model
export const getter = getters