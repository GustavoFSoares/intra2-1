import service from "@/services/ombudsman"
import DemandService from "@/services/ombudsman/demands"
import TypeService from "@/services/ombudsman/types"

const getters = {
    getOmbudsmans: () => service.getOmbudsmans(),
    getOmbudsmanById: (id) => service.getOmbudsmans({ 'id':id }),
    
    getDemands: () => DemandService.getDemands(),
    getDemandById: (id) => DemandService.getDemands({ 'id':id }),
    
    getTypes: () => TypeService.getTypes(),
    getTypeById: (id) => TypeService.getTypes({ 'id':id }),
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

export const TypesModel = {
    doInsertType: (type) => TypeService.insert(type),
    doUpdateType: (type) => TypeService.update(type.id, type),
    doDeleteType: (id) => TypeService.delete(id),
}

export default model

export const getter = getters
export const TypeModel = TypesModel
export const DemandModel = DemandsModel