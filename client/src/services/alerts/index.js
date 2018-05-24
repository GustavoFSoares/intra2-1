import http from '../client'

const getAlerts = () => {
    return http.get(`/alert/`).then(res => res.data)
}
const getAlert = (id) => {
    return http.get(`/alert/${id}`).then(res => res.data)
}

const saveData = (data) => {
    return http.post(`/alert/`, data).then(res => res.data)
}
const editData = (id, data) => {
    return http.put(`/alert/${id}`, data).then(res => res.data)
}

const removeData = (id, data) => {
    return http.delete(`/alert/${id}`).then(res => res.data)
}

export default {
    getAlerts,
    getAlert,
    saveData,
    editData,
    removeData,
}

