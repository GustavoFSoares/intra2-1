import http from '../client'

export default {
    getSectors: (params = {} ) => {
        return http.get(`/incident-origin/`, { params: params }).then(res => res.data)
    },

    doInsert: (data) => {
        return http.post(`/incident-origin/`, data).then(res => res.data)
    },

    doUpdate: (id, data) => {
        return http.put(`/incident-origin/${id}`, data).then(res => res.data)
    },

    doDelete: (id) => {
        return http.delete(`/incident-origin/${id}`).then(res => res.data)
    },
}