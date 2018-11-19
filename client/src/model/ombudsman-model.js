import service from "@/services/ombudsman"
import DemandService from "@/services/ombudsman/demands"

const getters = {
    getOmbudsmans: () => service.getOmbudsmans(),
    getOmbudsmanById: (id) => service.getOmbudsmans({ 'id':id }),
    
    getDemands: () => DemandService.getDemands(),
    getDemandById: (id) => DemandService.getDemands({ 'id':id }),
}

const model = {
    isEdit: (id) => id ? true : false,

    doInsertDemand: (demand) => DemandService.insert(demand),
    doUpdateDemand: (demand) => DemandService.update(demand.id, demand),
    doDeleteDemand: (id) => DemandService.delete(id),
    changeDemandStatus: (demand) => {
        demand.active = !demand.active
        
        
        
        return model.doUpdateDemand(demand)
    }
}

export default model
export const getter = getters