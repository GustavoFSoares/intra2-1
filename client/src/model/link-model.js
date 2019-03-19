import service from "@/services/links"

const getters = {
    getLinks: () => service.getLinks(),
    getLinksActive: () => service.getLinks({ 'active': 1 }),
    getLinkById: (id) => service.getLinks({ 'id': id }),
}

const model = {
    doInsert: (data) => service.doInsert(data),
    isEdit(id) {
        if (id) {
            return true
        }
        return false
    },
    doUpdate: (id, data) => service.doUpdate(id, data),
    doDelete: (id) => service.doDelete(id),
    doUnactive: (id) => service.doUnactive(id),
    saveImage: (imageName, file) => service.saveImage(imageName, file),
    changeStatus: (link) => {
        link.active = !link.active
        return service.changeStatus(link.id, link)
    }
}

export const getter = getters
export default model