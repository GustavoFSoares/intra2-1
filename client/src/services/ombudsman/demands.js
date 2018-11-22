import http from '../client'

export default {
    getDemands: (filter = {}) =>
        http.get(`/ombudsman/demands/`, { params: filter }).then(res => res.data),

    insert: (demand) =>
        http.post(`/ombudsman/demands/`, demand).then(res => res.data),
    
    update: (id, demand) =>
        http.put(`/ombudsman/demands/${id}`, demand).then(res => res.data),
    
    delete: (id) =>
        http.delete(`/ombudsman/demands/${id}`).then(res => res.data),
}