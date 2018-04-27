import http from '../client'

const sendMail = (mail) => {
    return http.post(`/mail/send`, mail).then(res => {
        return res.data
    })
}

const saveData = (mail) => {
    return http.post(`/adverse-events/save`, mail).then(res => {
        return res.data
    })
}

const getEvents = () => {
    return http.get(`/event/`).then(res => {
        return res.data
    })
}

const getEnterprises = () => {
    return http.get(`/enterprise/`).then(res => {
        return res.data
    })
}

export default {
    sendMail,
    saveData,
    getEvents,
    getEnterprises,
}