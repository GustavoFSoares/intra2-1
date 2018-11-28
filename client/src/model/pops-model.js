import service from "@/services/pops"

const getters = {
    getPops: () => service.getPops(),
}

const model = { }

export default model
export const getter = getters