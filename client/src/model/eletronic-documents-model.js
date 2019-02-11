import service from "@/services/eletronic-documents"
import SignatureService from "@/services/eletronic-documents/signature"
import StatusService from "@/services/eletronic-documents/status"
import TypeService from "@/services/eletronic-documents/type"

export const getter = {
    getEletronicDocuments: () => service.getEletronicDocuments({ 'user_id': window.$session.get('user').id }),
    getEletronicDocumentById: (id) => service.getEletronicDocuments({ 'id': id, 'user_id': window.$session.get('user').id }),

    getStatus: () => StatusService.getStatus(),
    getStatusById: (id) => StatusService.getStatus({ 'id': id }),

    getTypes: () => TypeService.getTypes(),
    getTypeById: (id) => TypeService.getTypes({ 'id': id }),

    getUsersSigned: (id) => SignatureService.getUsersSignedByDocumentId(id),
    getNextUserToSign: (id) => SignatureService.getNextUserToSignByDocumentId(id),
}

const model = {
    isEdit: (id) => id ? true : false,
    doUpdate: (eletronicDocument) => service.update(eletronicDocument.id, eletronicDocument),
    doInsert: (eletronicDocument) => service.insert(eletronicDocument),
    doDelete: (eletronicDocumentId) => service.delete(eletronicDocumentId),
    setLikeWaitingSignature: (id) => service.setDocumentLikeWaitingSignature(id),    
    signDocumentLikeCreator: (id, data) => service.signDocument(id, 'creator', data),
    signDocumentLikeUser: (id, data) => service.signDocument(id, 'user-of-list', data),
    updateAmendment: (eletronicDocument) => service.updateAmendment(eletronicDocument.id, eletronicDocument),
    doUploadFile: (file, fileName, prefix) => service.uploadFile(file, fileName, prefix),
    setLikeCanceld: (id) => service.setDocumentLikeCanceled(id),
    setLikeArchived: (eletronicDocument) => {
        eletronicDocument.archived = true
        
        return service.setDocumentLikeArchived(eletronicDocument.id, eletronicDocument)   
    },
}

export const StatusModel = {
    doInsertStatus: (status) => StatusService.insert(status),
    doUpdateStatus: (status) => StatusService.update(status.id, status),
    doDeleteStatus: (id) => StatusService.delete(id),
}

export const TypeModel = {
    doInsertType: (type) => TypeService.insert(type),
    doUpdateType: (type) => TypeService.update(type.id, type),
    doDeleteType: (id) => TypeService.delete(id),
}
export default model