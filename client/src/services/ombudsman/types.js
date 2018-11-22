import http from '../client'

export default {
    getTypes: (filter = {}) =>
        http.get(`/ombudsman/types/`, { params: filter }).then(res => res.data),

    insert: (type) =>
        http.post(`/ombudsman/types/`, type).then(res => res.data),

    update: (id, type) =>
        http.put(`/ombudsman/types/${id}`, type).then(res => res.data),

    delete: (id) =>
        http.delete(`/ombudsman/types/${id}`).then(res => res.data),
}