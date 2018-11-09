import service from "@/services/rotines"

const getters = {
    getRotines: () => service.getRotines(),
    getAvailableRotines: () => service.getAvailableRotines(),
    getLogsByRotine: (id) => service.getLogsByRotine(id),
}

const model = {
    execute: (rotine) => service.execute(rotine),
}

export default model
export const getter = getters