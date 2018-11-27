import service from "@/services/ombudsman"
import DemandService from "@/services/ombudsman/demands"
import OriginService from "@/services/ombudsman/origin"

const getters = {
    getOmbudsmans: () => service.getOmbudsmans({ }),
    getOmbudsmansReported: () => service.getOmbudsmans({ 'reported': 1 }),
    getOmbudsmansWaiting: () => service.getOmbudsmans({ 'reported': 0 }),
    getOmbudsmanById: (id) => service.getOmbudsmans({ 'id':id }),
    
    getDemands: () => DemandService.getDemands(),
    getDemandById: (id) => DemandService.getDemands({ 'id':id }),
    
    getOrigins: () => OriginService.getOrigins(),
    getOriginById: (id) => OriginService.getOrigins({ 'id':id }),
}

const model = {
    isEdit: (id) => id ? true : false,
}

const DemandsModel = {
    doInsertDemand: (demand) => DemandService.insert(demand),
    doUpdateDemand: (demand) => DemandService.update(demand.id, demand),
    doDeleteDemand: (id) => DemandService.delete(id),
    changeDemandStatus: (demand) => {
        demand.active = !demand.active

        return DemandsModel.doUpdateDemand(demand)
    },
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