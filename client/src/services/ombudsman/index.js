import http from '../client'

export default  {
    getOmbudsmans: (filter = {}) =>
        http.get('/ombudsman/', { params: filter }).then(res => res.data ),
}
