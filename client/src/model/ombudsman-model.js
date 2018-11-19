import service from "@/services/ombudsman"

const getters = {
    getOmbudsmans: () => service.getOmbudsmans(),
    getOmbudsmanById: (id) => service.getOmbudsmans({ 'id':id }),
}

const model = {
    isEdit: (id) => id ? true : false
}

export default model
export const getter = getters