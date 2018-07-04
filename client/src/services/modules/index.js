import http from '../client'

const getModules = (id) => {
    return http.get(`/module/`, { params: {id: id} }).then(res => res.data )
}
const getModulesByGroup = (group) => {
    return http.get(`/module/group/${group}`).then(res => res.data)
}

const doPermission = (data) => {
    return http.post(`/module/group/`, data).then(res => res.data)
}
const addModule = (data) => {
    return http.post(`/module/`, data).then(res => res.data)
}

const editModule = (id, data) => {
    return http.put(`/module/${id}`, data).then(res => res.data)
}

const changeStatusModule = (id) => {
    return http.put(`/module/change-status/${id}`).then(res => res.data)
}

const deleteModule = (id) => {
    return http.delete(`/module/${id}`).then(res => res.data)
}

export default {
    getModulesByGroup,
    getModules,
    doPermission,
    addModule,
    editModule,
    deleteModule,
    changeStatusModule,
}

