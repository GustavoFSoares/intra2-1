import http from '../client'

export default {
    getUsers: (filter = {}) =>
        http.get(`/user/`, { params: filter }).then(res => res.data),
    editUsers: (data) =>
        http.put(`/user/`, data).then(res => res.data),
    editUser: (id, data) =>
        http.put(`/user/${id}`, data).then(res => res.data),
}