import http from '../client'

const sendMail = (mail) => {
    return http.post(`/mail/send`, mail).then( res => res.data )
}

const saveData = (mail) => {
    return http.post(`/adverse-events/save`, mail).then( res => res.data ) 
}

const getEvents = () => {
    return http.get(`/event/`).then( res => res.data )
}

const getEnterprises = () => {
    return http.get(`/enterprise/`).then( res => res.data )
}

const getSectorsBy = (id) => {
    return http.get(`/sector/enterprise/${id}`).then( res => res.data )
}

export default {
    sendMail,
    saveData,
    getEvents,
    getEnterprises,
    getSectorsBy,
}