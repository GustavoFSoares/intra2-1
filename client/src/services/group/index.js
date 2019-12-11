import http from '../client'
export default {
    getGroups: (id) => 
        http.get(`/group/`, { params: { id: id, c_removed: 0 } }).then(res => res.data),
    getEnterprises: () => 
        http.get(`/group/enterprises/`).then(res => res.data),
    getGroupsByEnterprise: (enterprise) => 
        http.get(`/group/enterprise/${enterprise}`).then(res => res.data),
    getOriginsByEnterprise: (enterprise) =>
        http.get(`/incident-origin/enterprise/${enterprise}`).then(res => res.data),
}