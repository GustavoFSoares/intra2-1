import http from '../client'

const getCovenants = (id) => {
    return http.get(`/covenants/`, { params: { id: id } }).then(res => res.data)
}

const addCovenant = (data) => {
    return http.post(`/covenants/`, data).then(res => res.data)
}

const editCovenant = (id, data) => {
    return http.put(`/covenants/${id}`, data).then(res => res.data)
}

const changeStatusCovenant = (id) => {
    return http.put(`/covenants/change-status/${id}`).then(res => res.data)
}

const deleteCovenant = (id) => {
    return http.delete(`/covenants/${id}`).then(res => res.data)
}

export default {
    getCovenants,
    addCovenant,
    editCovenant,
    changeStatusCovenant,
    deleteCovenant,
}

