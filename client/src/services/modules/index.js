import http from '../client'

export default {
    getModules: (id) => {
        return http.get(`/module/`, { params: {id: id} }).then(res => res.data )
    },
    getModulesByGroup: (group) => {
        return http.get(`/module/group/${group}`).then(res => res.data)
    },
    
    doPermission: (data) => {
        return http.post(`/module/group/`, data).then(res => res.data)
    },
    addModule: (data) => {
        return http.post(`/module/`, data).then(res => res.data)
    },
    addChieldModule: (data) => {
        return http.post(`/module/chield/`, data).then(res => res.data)
    },
    
    editModule: (id, data) => {
        return http.put(`/module/${id}`, data).then(res => res.data)
    },
    editChieldModule: (id, data) => {
        return http.put(`/module/chield/${id}`, data).then(res => res.data)
    },
    changeStatusModule: (id) => {
        return http.put(`/module/change-status/${id}`).then(res => res.data)
    },
    
    deleteModule: (id) => {
        return http.delete(`/module/${id}`).then(res => res.data)
    },
    removeChield: (id) => {
        return http.delete(`/module/chield/${id}`).then(res => res.data)
    },
}