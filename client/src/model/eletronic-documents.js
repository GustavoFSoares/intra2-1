import service from "@/services/eletronic-documents"
import StatusService from "@/services/eletronic-documents/status"
import TypeService from "@/services/eletronic-documents/types"

export const getters = {
    getEletronicDocuments: () => service.getEletronicDocuments({}),
    getEletronicDocumentById: (id) => service.getEletronicDocuments({ 'id': id, 'user_id': window.$session.get('user').id }),

    getStatus: () => Statuservice.getStatus(),
    getStatusById: (id) => statusService.getStatus({ 'id': id }),

    getTypes: () => TypeService.getTypes(),
    getTypeById: (id) => TypeService.getTypes({ 'id': id }),
}

const model = {
    isEdit: (id) => id ? true : false,
    doUpdate: (eletronicDocument) => service.update(eletronicDocument.id, eletronicDocument),
    doInsert: (eletronicDocument) => service.insert(eletronicDocument),
    doDelete: (eletronicDocumentId) => service.delete(eletronicDocumentId),
    // addManager: (ombudsmanId, user, type) => service.addManager(ombudsmanId, user, type),
    // removeManager: (ombudsmanId, user, type) => service.removeManager(ombudsmanId, user, type),
    // uploadFile: (file, fileName) => service.uploadFile(file, fileName),
    // closeChat: (ombudsman) => service.closeChat(ombudsman.id, ombudsman),
    // finishOmbudsman: (ombudsman) => service.finishOmbudsman(ombudsman.id, ombudsman),
}

export const StatusModel = {
    doInsertStatus: (status) => StatusService.insert(status),
    doUpdateStatus: (status) => StatusService.update(status.id, status),
    doDeleteStatus: (id) => StatusService.delete(id),
}

export const TypesModel = {
    doInsertType: (type) => TypeService.insert(type),
    doUpdateType: (type) => TypeService.update(type.id, type),
    doDeleteType: (id) => TypeService.delete(id),
}
export default model