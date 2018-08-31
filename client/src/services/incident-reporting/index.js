import http from '../client'

export default {
    getEvents: () => 
        http.get(`/event/`).then(res => res.data),
    
    doInsert: (data) =>
        http.post(`/incident-reporting/`, data).then(res => res.data),

}