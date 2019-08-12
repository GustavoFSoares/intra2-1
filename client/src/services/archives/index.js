import http from '../client'
export default {
    getArchives: () =>
        http.get(`/file/archives/`).then(res => res.data),
}