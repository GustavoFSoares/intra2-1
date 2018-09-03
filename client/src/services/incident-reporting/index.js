import http from '../client'

export default {
    getIncidents: (id) =>
        http.get(`/incident-reporting/`, { params: { id: id } }).then(res => res.data),
    getEvents: () => 
        http.get(`/event/`).then(res => res.data),
    
    doInsert: (data) =>
        http.post(`/incident-reporting/`, data).then(res => res.data),

}