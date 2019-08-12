import service from "@/services/comissions"

const getters = {
    getComissions: () => service.getComissions(),
}

const model = { }

export default model
export const getter = getters