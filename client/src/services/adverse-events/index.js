import http from '../client'

export const sendMail = (mail) => {
    return http.post(`/mail/send`, mail).then(res => {
        return res.data
    })
}

export const saveData = (mail) => {
    return http.post(`/adverse-events/save`, mail).then(res => {
        return res.data
    })
}

