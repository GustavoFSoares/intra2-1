import http from '../client'

export default {
    getTypes: (filter = {}) =>
        http.get(`/ombudsman/types/`, { params: filter }).then(res => res.data),

    insert: (demand) =>
        http.post(`/ombudsman/types/`, demand).then(res => res.data),

    update: (id, demand) =>
        http.put(`/ombudsman/types/:${id}`, demand).then(res => res.data),

    delete: (id) =>
        http.delete(`/ombudsman/types/:${id}`, demand).then(res => res.data),
}