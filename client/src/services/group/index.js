import http from '../client'
export default {
    getGroups: (id) => 
        http.get(`/group/`, { params: { id: id } }).then(res => res.data),
    getEnterprises: () => 
        http.get(`/group/enterprises/`).then(res => res.data),
    getGroupsByEnterprise: (enterprise) => 
        http.get(`/group/enterprise/${enterprise}`).then(res => res.data),
}