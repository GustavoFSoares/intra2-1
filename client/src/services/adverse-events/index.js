import http from '../client'

const sendData = (data) => {
    return http.post(`/adverse-events/send`, data).then( res => res.data ) 
}

// =================================================================================
const getEvents = () => {
    return http.get(`/event/`).then(res => res.data)
}

const getEnterprises = () => {
    return http.get(`/enterprise/`).then(res => res.data)
}

const getSectorsBy = (id) => {
    return http.get(`/sector/enterprise/${id}`).then(res => res.data)
}
// =================================================================================
const getEventById = (id) => {
    return http.get(`/event/${id}`).then(res => res.data )
}

const getEnterpriseById = (id) => {
    return http.get(`/enterprise/${id}`).then(res => res.data)
}

const getSectorById = (id) => {
    return http.get(`/sector/${id}`).then(res => res.data)
}
// =================================================================================
export default {
    sendData,
    getEvents,
    getEnterprises,
    getSectorsBy,
}

export const getters = {
    getEventById,
    getEnterpriseById,
    getSectorById,
}