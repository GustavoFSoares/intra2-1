import http from '../client'

export const getWarning = () => {
    return http.get(`/alert/type/warning`).then(res => res.data)
}

export const getDanger = () => {
    return http.get(`/alert/type/danger`).then(res => res.data)
}

export default {
    getWarning,
    getDanger,
}