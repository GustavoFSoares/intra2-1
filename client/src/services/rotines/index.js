import http from '../client'
export default {
    getRotines: (filter = {}) =>
        http.get(`/rotine/`, { params: filter }).then(res => res.data),
    getAvailableRotines: () =>
        http.get(`/rotine/available/`).then(res => res.data),
    getLogsByRotine: (id) =>
        http.get(`/rotine/logs/${id}`).then(res => res.data),

    execute: (rotine) => 
        http.post(`/rotine/execute/`, rotine).then(res => res.data)
}