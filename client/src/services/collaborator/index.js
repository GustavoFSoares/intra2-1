import http from '../client'

export default {
    getCollaborators: (id) => {
        return http.get(`/collaborator/`, { params: { id: id } }).then(res => res.data)
    },
    getCollaboratorsByGroupId: (group) => {
        return http.get(`/collaborator/group/${group}`).then(res => res.data)
    },
    getTypes: () => {
        return http.get(`/collaborator/type/`).then(res => res.data)
    },
    insertCollaborator: (data) => {
        return http.post(`/collaborator/`, data).then(res => res.data)
    },
    updateCollaborator: (id, data) => {
        return http.put(`/collaborator/${id}`, data).then(res => res.data)
    },
    deleteCollaborator: (id) => {
        return http.delete(`/collaborator/${id}`).then(res => res.data)
    },
}