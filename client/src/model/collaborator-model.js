import service from "@/services/collaborator"
import serviceGroup from "@/services/group"

const getters = {
    getCollaborators: () => service.getCollaborators(),
    getCollaboratorById: (id) => service.getCollaborators(id),
    getCollaboratorTypes: () => service.getTypes(),
    getCollaboratorsByGroupId: (groupId) => service.getCollaboratorsByGroupId(groupId),
    getGroups: () => serviceGroup.getGroups(),
}

const model = {
    doInsert: (data) => service.insertCollaborator(data),
    doUpdate: (id, data) => service.updateCollaborator(id, data),
    doDelete: (id) => service.deleteCollaborator(id),
    isEdit(id) {
        if (id) {
            return true
        }
        return false
    },
}

export default model
export const getter = getters