import service from "@/services/user"
import User from "@/entity/User";

const getters = {
    // getUsers: () => service.getUsers({ 'active': 1 }),
    getUserById: (id) => service.getUsers({ 'id':id }),
    getUserByName: (name) => service.getUsers({ 'name':name }),
    getUsersByNameOrCode: (finding) => service.getUsersByNameOrCode({ 'name': finding, 'code': finding }),
    getUsersByGroupId: (groupId) => service.getUsers({ 'group':groupId }),
    getUsersActivedByGroupId: (groupId) => service.getUsers({ 'group': groupId, 'active': 1 }),
    getUsersAdmin: () => service.getUsers({ 'admin':1, 'active':1 }),
    getUsersAdminWithEmail: () => service.getUsersAdminWithEmail({ 'active': 1 }),
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
    }),
    doDelete: (userId) => service.delete(userId),
}

export default model
export const getter = getters