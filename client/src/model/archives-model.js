import service from "@/services/archives"

const getters = {
    getArchives: () => service.getArchives(),
}

const model = { }

export default model
export const getter = getters