import http from '../client'

export default {
    getAllRamals: (id) => {
        return http.get(`/ramal/all/`, { params: { id: id } }).then( res => res.data )
    },
    getRamals: (id) => {
        return http.get(`/ramal/`, { params: { id: id } }).then( res => res.data )
    },
    
    doInsert: (data) => {
        return http.post(`/ramal/`, data).then( res => res.data )
    },
    doUpdate: (id, data) => {
        return http.put(`/ramal/${id}`, data).then( res => res.data )
    },
    doDelete: (id) => {
        return http.delete(`/ramal/${id}`).then( res => res.data )
    },
    doUnactive: (id) => {
        return http.delete(`/ramal/change-status/${id}`).then( res => res.data )
    },
}