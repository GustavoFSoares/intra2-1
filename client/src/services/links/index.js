import http from '../client'

export const getLinks = () => {
    return http.get(`/link/`).then( res => res.data )
}

export const getLink = (id) => {
    return http.get(`/link/`, { params: { id: id } }).then( res => res.data )
}