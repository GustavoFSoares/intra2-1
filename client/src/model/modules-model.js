import serviceGroup from "@/services/group"
import service from "@/services/modules"

const getModules = () => service.getModules()
const getGroups = () => serviceGroup.getGroups()

const getModulesByGroup = (group) => service.getModulesByGroup(group)

const doInsert = (data) => {
    service.saveData(data).then(res => '' )
    alert('Salvo')
}

export default {
    getModules,
    getGroups,
    doInsert,
    getModulesByGroup,
}