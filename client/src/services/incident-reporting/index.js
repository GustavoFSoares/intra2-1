import http from '../client'

export default {
    getIncidents: (id) =>
        http.get(`/incident-reporting/`, { params: { id: id } }).then(res => res.data),
    getEvents: () => 
        http.get(`/event/`).then(res => res.data),
    
    doInsert: (data) =>
        http.post(`/incident-reporting/`, data).then(res => res.data),
    
    addGroupToTransmissionList: (id, data) =>
        http.put(`/incident-reporting/add-group/${id}`, data).then(res => res.data),
    
    removeGroupToTransmissionList: (id, data) =>
        http.put(`/incident-reporting/remove-group/${id}`, data).then(res => res.data),

}