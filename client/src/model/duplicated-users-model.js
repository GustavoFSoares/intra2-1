import service from "@/services/duplicated-users"

const getters = {
    getDuplicatedUsers: () => service.getDuplicatedUsers(),
}

const model = {
    checkDuplicated: (duplicationId) => service.checkDuplicated(duplicationId),
    checkLikeNotDuplication: (duplicationId) => service.doDelete(duplicationId),
}

export default model
export const getter = getters