import http from '../client'

export default  {
    getOmbudsmans: (filter = {}) =>
        http.get('/ombudsman/', { params: filter }).then(res => res.data ),

    insert: (demand) =>
        http.post(`/ombudsman/`, demand).then(res => res.data),

    update: (id, demand) =>
        http.put(`/ombudsman/:${id}`, demand).then(res => res.data),

    delete: (id) =>
        http.delete(`/ombudsman/:${id}`, demand).then(res => res.data),
}
