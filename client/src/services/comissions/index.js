import http from '../client'
export default {
    getComissions: () =>
        http.get(`/file/comissions/`).then(res => res.data),
}