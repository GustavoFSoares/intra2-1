import http from '../client'

export default {
    getLinks: (params = {} ) => {
        return http.get(`/link/`, { params: params }).then(res => res.data)
    },

    doInsert: (data) => {
        return http.post(`/link/`, data).then(res => res.data)
    },
    saveImage: (imageName, file) => {
        return http.post(`/link/save-image/{name}`, file, { params: { name: imageName } }).then(res => res.data)
    },

    doUpdate: (id, data) => {
        return http.put(`/link/${id}`, data).then(res => res.data)
    },
    changeStatus: (id, data) => {
        return http.put(`/link/change-status/${id}`, data).then(res => res.data)
    },

    doDelete: (id) => {
        return http.delete(`/link/${id}`).then(res => res.data)
    },

    doUnactive: (id) => {
        return http.delete(`/link/change-status/${id}`).then(res => res.data)
    },
}