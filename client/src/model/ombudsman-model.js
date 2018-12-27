import service from "@/services/ombudsman"
import DemandService from "@/services/ombudsman/demands"
import OriginService from "@/services/ombudsman/origin"

const getters = {
    getOmbudsmans: () => service.getOmbudsmans({ }),
    getOmbudsmansReported: () => service.getOmbudsmans({ 'reported': 1, 'user_id': window.$session.get('user').id }),
    getOmbudsmansWaiting: () => service.getOmbudsmansWaiting({ }),
    getOmbudsmanById: (id) => service.getOmbudsmans({ 'id': id, 'user_id': window.$session.get('user').id }),
    
    getDemands: () => DemandService.getDemands(),
    getDemandById: (id) => DemandService.getDemands({ 'id':id }),
    
    getOrigins: () => OriginService.getOrigins(),
    getOriginById: (id) => OriginService.getOrigins({ 'id':id }),
}

const model = {
    isEdit: (id) => id ? true : false,
    doUpdate: (demand) => service.update(demand.id, demand),

    doDelete: (demandId) => service.delete(demandId),
    gotPermission: (ombudsmanId = null) => service.getPermission({ 'id': ombudsmanId, 'user_id': window.$session.get('user').id }),
    setManagerResponse: (id, response) => service.setManagerResponse(id, { 
                                                                    'id': id,
                                                                    'manager': response.manager,
                                                                    'managerResponse': response.managerResponse,
                                                            }),
    setOmbudsmanToResponse: (id, response) => service.setOmbudsmanResponse(id, { 
                                                                    'id': id,
                                                                    'ombudsmanToResponse': response.ombudsman,
                                                                    'responseToUser': response.ombudsmanResponse,
                                                                }),
    addManager: (ombudsmanId, user, type) => service.addManager(ombudsmanId, user, type),
    removeManager: (ombudsmanId, user, type) => service.removeManager(ombudsmanId, user, type),
    uploadFile: (file, fileName) => service.uploadFile(file, fileName),
}

const DemandsModel = {
    doInsertDemand: (demand) => DemandService.insert(demand),
    doUpdateDemand: (demand) => DemandService.update(demand.id, demand),
    doDeleteDemand: (id) => DemandService.delete(id),
    changeDemandStatus: (demand) => {
        demand.active = !demand.active

        return DemandsModel.doUpdateDemand(demand)
    },
    demandExist: (demands, demandSelected) => {
        let exist = false
        
        demands.forEach(demand => {
            if (demand.id == demandSelected.id) {
                exist = true
            }
        });

        return exist
    }
}

const chats = {
    saveMessage: (id, message) => service.insertMessage({ 'id': id, 'message': message, 'user': window.$session.get('user') }) ,
    getChats: (id) => service.getChatsByOmbudsman({ 'id': id, 'user_id': window.$session.get('user').id }),
}

export const OriginsModel = {
    doInsertOrigin: (origin) => OriginService.insert(origin),
    doUpdateOrigin: (origin) => OriginService.update(origin.id, origin),
    doDeleteOrigin: (id) => OriginService.delete(id),
}

export default model

export const getter = getters
export const OriginModel = OriginsModel
export const DemandModel = DemandsModel
export const chat = chats