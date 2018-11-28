import http from '../client'
export default {
    getPops: () =>
        http.get(`/file/pops/`).then(res => res.data),
}