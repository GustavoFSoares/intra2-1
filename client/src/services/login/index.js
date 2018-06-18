import http from '../client'

const loginAuth = (data) => {
    return http.post(`/login/`, data).then( res => res.data ) 
}

export default {
    loginAuth,
}