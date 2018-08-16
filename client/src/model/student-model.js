import service from "@/services/student"
import serviceGroup from "@/services/group"
// import Student from '@/entity/Student'

const getters = {
    getStudents: () => service.getStudents(),
    getStudentById: (id) => service.getStudents(id),
    getStudentsByGroupId: (groupId) => service.getStudentsByGroupId(groupId),
    getGroups: () => serviceGroup.getGroups(),
}

const model = {
    doInsert: (data) => service.insertStudent(data),
    doUpdate: (id, data) => service.updateStudent(id, data),
    doDelete: (id) => service.deleteStudent(id),
    isEdit(id) {
        if (id) {
            return true
        }
        return false
    },
}

export default model
export const getter = getters