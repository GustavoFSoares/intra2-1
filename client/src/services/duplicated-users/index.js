import http from '../client'
export default {
    getDuplicatedUsers: (filter = {}) =>
       http.get(`/duplicated-users/`, { params: filter }).then(res => res.data),

    checkDuplicated: (id) =>
        http.put(`/duplicated-users/check-duplicated/${id}`).then(res => res.data),
    
    doDelete: (id) =>
        http.delete(`/duplicated-users/${id}`).then(res => res.data),
}