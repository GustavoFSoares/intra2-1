import http from '../client'

export default {
    getOrigins: (filter = {}) =>
        http.get(`/ombudsman/origin/`, { params: filter }).then(res => res.data),

    insert: (type) =>
        http.post(`/ombudsman/origin/`, type).then(res => res.data),

    update: (id, type) =>
        http.put(`/ombudsman/origin/${id}`, type).then(res => res.data),

    delete: (id) =>
        http.delete(`/ombudsman/origin/${id}`).then(res => res.data),
}