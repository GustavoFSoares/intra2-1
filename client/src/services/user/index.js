import http from '../client'

export default {
    getUsers: (filter = {}) => 
        http.get(`/user/`, { params: filter }).then(res => res.data),
    getUsersByNameOrCode: (filter = {}) => 
        http.get(`/user/user-by-name-or-code/`, { params: { 'name': filter.name, 'code': filter.code } }).then(res => res.data),
    getUsersAdminWithEmail: () =>
        http.get(`/user/users-admin-email/`).then(res => res.data),
    
    editUsers: (data) =>
        http.put(`/user/`, data).then(res => res.data),
    editUser: (id, data) =>
        http.put(`/user/${id}`, data).then(res => res.data),

    delete: (id) => {
        window.httpMessage = { show: true, success: `Usuário <b>Excluído</b>`, error: "Usuário <b>não Excluído</b>" }        
        return http.delete(`/user/${id}`).then(res => res.data)
    }
}