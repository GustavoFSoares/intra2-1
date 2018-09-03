import service from "@/services/incident-reporting";
import { EmailDefault } from "@/entity";
const GroupModel = require("@/model/group-model").getter

const getters = {
    getIncidents: () => service.getIncidents(),
    getIncidentById: (id) => service.getIncidents(id),
    getEvents: () => service.getEvents(),
}
export default {
    doInsert: (report) => service.doInsert(report),
    loadSectors: (id) => {
        let data
        return new Promise((resolve) => {
            GroupModel.getGroupsByEnterprise(id).then(res => {
                data = null
                if (id == 'HU' || id == 'HPSC') {
                    data = { sectors: true, value: res }
                } else {
                    data = { enterprise: true, value: res[0] }
                }
                resolve(data)
            })
        })
    }

}
export const getter = getters