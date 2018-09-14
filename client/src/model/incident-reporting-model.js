import service from "@/services/incident-reporting";
const GroupModel = require("@/model/group-model").getter
const getters = {
    getIncidents: () => service.getIncidents(),
    getIncidentById: (id) => service.getIncidents(id),
    getEvents: () => service.getEvents(),
    getChatsByIncident: (incidentId) => service.getChatsByIncident(incidentId),
}
var model = {
    socket: '',
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

}
export default model
export const getter = getters