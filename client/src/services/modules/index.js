import http from '../client'

const getModules = () => {
    return http.get(`/module/`).then(res => res.data)
}
const getModulesByGroup = (group) => {
    return http.get(`/module/group/${group}`).then(res => res.data)
}

const saveData = (data) => {
    return http.post(`/module/`, data).then(res => res.data)
}

export default {
    getModulesByGroup,
    getModules,
    saveData,
}

