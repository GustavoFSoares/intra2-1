import service from "@/services/incident-reporting";
const PermissionList = [
    'tecnologia-da-informacao-hu',
    'seger-hu'
]

const GroupModel = require("@/model/group-model").getter
const getters = {
    getIncidents: () => service.getIncidents({ 'user_id': window.$session.get('user').id }),
    getIncidentsWithFilters: (group, filters) => service.getIncidents(
        { 'filtered': 1, 'closed': filters.closed }
    ),
    getIncidentById: (id) => service.getIncidents({ 'id': id, 'user_id': window.$session.get('user').id }),
    getHistoricByIncident: (id) => service.getHistoricByIncident(id),
    getEvents: () => service.getEvents(),
    getChatsByIncident: (incidentId) => service.getChatsByIncident({ 'id': incidentId, 'user_id': window.$session.get('user').id }),
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
    addUserToTransmissionList: (incidentId, data) => service.addUserToTransmissionList(incidentId, data),
    removeUserToTransmissionList: (incidentId, data) => service.removeUserToTransmissionList(incidentId, data),
    gotPermission: (incidentId = null) => service.getUserPermission({ 'id': incidentId, 'user_id': window.$session.get('user').id })
}
export default model
export const getter = getters