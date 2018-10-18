import http from '../client'

export default {
    getIncidents: (filter = {}) =>
        http.get(`/incident-reporting/`, { params: filter }).then(res => res.data),
    getEvents: () => 
        http.get(`/event/`).then(res => res.data),
    getChatsByIncident: (filter = {}) => 
        http.get(`/incident-reporting/messages/`, { params: filter }).then(res => res.data),
    getHistoricByIncident: (id) => 
        http.get(`/incident-reporting/historic/${id}`).then(res => res.data),
    getUserPermission: (filter = {}) => 
        http.get(`/incident-reporting/permission/`, { params: filter }).then(res => res.data),
    

    doInsert: (data) =>
        http.post(`/incident-reporting/`, data).then(res => res.data),
    insertMessage: (data) =>
        http.post(`/incident-reporting/messages/`, data).then(res => res.data),


    doUpdate: (id, data) =>
        http.put(`/incident-reporting/${id}`, data).then(res => res.data),
    closeReport: (id) =>
        http.put(`/incident-reporting/close/${id}`).then(res => res.data),
    addUserToTransmissionList: (id, data) =>
        http.put(`/incident-reporting/add-user/${id}`, data).then(res => res.data),
    removeUserToTransmissionList: (id, data) =>
        http.put(`/incident-reporting/remove-user/${id}`, data).then(res => res.data),
    

    cleanNotification: (id, data) =>
        http.delete(`/incident-reporting/clean-notification/`, { params: data }).then(res => res.data),


}