import service from "@/services/incident-reporting";
const PermissionList = [
    'tecnologia-da-informacao-hu',
    'seger-hu'
]

const GroupModel = require("@/model/group-model").getter
const getters = {
    getIncidents: (group) => {
        return model.gotPermission(group).then(permission => {
            if (permission) {
                return service.getIncidents()
            }
            return service.getIncidents({ 'failedPlace':group.id, 'filtered': 1 })
        })
        
    },
    getIncidentById: (id) => service.getIncidents({'id': id}),
    getHistoricByIncident: (id) => service.getHistoricByIncident(id),
    getEvents: () => service.getEvents(),
    getChatsByIncident: (incidentId) => service.getChatsByIncident(incidentId),
}
var model = {
    socket: '',
    doInsert: (report) => service.doInsert(report),
    doUpdate: (id, report) => service.doUpdate(id, report),
    closeReport: (id) => service.closeReport(id),
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
    },
    chatInit: (socket) => {
        model.socket = socket
    },
    sendMessage: (id, message) => {
        model.socket.sendMessage(message)
        model.insertMessage(id, message)
    },
    insertMessage: (id, message) => service.insertMessage({ 'id': id, 'message': message, 'user': window.$session.get('user') }),
    addGroupToTransmissionList: (incidentId, data) => service.addGroupToTransmissionList(incidentId, data),
    removeGroupToTransmissionList: (incidentId, data) => service.removeGroupToTransmissionList(incidentId, data),
    gotPermission: (group) => {
        return new Promise(resolve => {
            PermissionList.forEach(list => {
                if(group.groupId == list) {
                    resolve(true)
                }
            })

            resolve(false)
        })
    }
}
export default model
export const getter = getters