import http from '../client'

export default {
    getIncidents: (filter = {}) =>
        http.get(`/incident-reporting/`, { params: filter }).then(res => res.data),
    getEvents: () => 
        http.get(`/event/`).then(res => res.data),
    getChatsByIncident: (id) => 
        http.get(`/incident-reporting/messages/${id}`).then(res => res.data),
    
    doInsert: (data) =>
        http.post(`/incident-reporting/`, data).then(res => res.data),
    insertMessage: (data) =>
        http.post(`/incident-reporting/messages/`, data).then(res => res.data),

    doUpdate: (id, data) =>
        http.put(`/incident-reporting/${id}`, data).then(res => res.data),
    
    closeReport: (id) =>
        http.put(`/incident-reporting/close/${id}`).then(res => res.data),
    
    addGroupToTransmissionList: (id, data) =>
        http.put(`/incident-reporting/add-group/${id}`, data).then(res => res.data),
    
    removeGroupToTransmissionList: (id, data) =>
        http.put(`/incident-reporting/remove-group/${id}`, data).then(res => res.data),

}