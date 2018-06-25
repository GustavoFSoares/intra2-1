import http from '../client'

const getGroups = () => {
    return http.get(`/group/`).then(res => res.data)
}

const getGroup = (id) => {
    return http.get(`/group/${id}`).then(res => res.data)
}


export default {
    getGroup,
    getGroups,
}