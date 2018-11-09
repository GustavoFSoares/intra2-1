import http from '../client'
export default {
    getRoomsTraining: (filter = {}) =>
        http.get(`/room-training/`, { params: filter }).then(res => res.data),

    insert: (roomTraining) =>
        http.post(`/room-training/`, roomTraining).then(res => res.data),
    
    update: (id, roomTraining) =>
        http.put(`/room-training/${id}`, roomTraining).then(res => res.data),

    delete: (id) => 
        http.delete(`/room-training/${id}`).then(res => res.data),
} 