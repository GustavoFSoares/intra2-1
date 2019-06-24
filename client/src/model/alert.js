import service from "@/services/alerts"

const getAlerts = () => service.getAlerts()
const getAlert = (id) => service.getAlert(id)

const save = (data) => {
    data.type = data.type.value
    
    return service.saveData(data)
}

const edit = (id, data) => {
    data.type = data.type.value
    return service.editData(id, data)
}

const remove = (id) => service.removeData(id)

const isEdit = (id) => {
    if(id){
        return true
    } else {
        return false
    }
}

export default {
    getAlerts, getAlert,
    save, edit, remove,
    isEdit,
}