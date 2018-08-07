import http from '../client'

export default {
    getStudents: (id) => {
        return http.get(`/student/`, { params: { id: id } }).then(res => res.data)
    },
    getStudentsByGroupId: (group) => {
        return http.get(`/student/group/${group}`).then(res => res.data)
    },
    insertStudent: (data) => {
        return http.post(`/student/`, data).then(res => res.data)
    },
    updateStudent: (id, data) => {
        return http.put(`/student/${id}`, data).then(res => res.data)
    },
    deleteStudent: (id) => {
        return http.delete(`/student/${id}`).then(res => res.data)
    },
}