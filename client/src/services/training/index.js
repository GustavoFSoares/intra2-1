import http from '../client'

export default {
    getTrainingsType: (id) => {
        return http.get(`/training/type/`, { params: { id: id } }).then( res => res.data )
    },
    getTrainings: (filters = {}) => {
        return http.get(`/training/`, { params: filters }).then(res => res.data )
    },
    getTrainingsUnrealized: () => {
        return http.get(`/training/unrealized/`).then(res => res.data )
    },
    
    doInsert: (data) => {
        return http.post(`/training/`, data).then( res => res.data )
    },

    doUpdate: (id, data) => {
        return http.put(`/training/${id}`, data).then( res => res.data )
    },
    isDone: (id) => {
        return http.put(`/training/done/${id}`).then( res => res.data )
    },
    
    doDelete: (id) => {
        return http.delete(`/training/${id}`).then( res => res.data )
    }
}