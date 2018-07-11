import http from '../client'

export default {
    getUsers: (id) => {
        return http.get(`/user/`, { params: { id: id } }).then(res => res.data)
    },
    getUsersByGroupId: (group) => {
        return http.get(`/user/group/${group}`).then(res => res.data)
    },
    editUser: (id, data) => {
        return http.put(`/user/${id}`, data).then(res => res.data)
    }
}