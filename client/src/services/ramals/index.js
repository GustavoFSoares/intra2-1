import http from '../client'

const getRamals = () => {
    return http.get(`/ramal/`).then( res => res.data )
}

export default {
    getRamals
}