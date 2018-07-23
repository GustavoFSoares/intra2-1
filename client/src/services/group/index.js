import http from '../client'
export default {
    getGroups: () => 
        http.get(`/group/`).then(res => res.data),
    getGroup: (id) => 
        http.get(`/group/`, { params: { id: id } }).then(res => res.data),
    getEnterprises: () => 
        http.get(`/group/enterprises/`).then(res => res.data),
}