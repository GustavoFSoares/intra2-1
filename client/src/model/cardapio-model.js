import service from "@/services/cardapio"

export const getter = {
    getCardapioMenu: () => service.getCardapioMenu(),
}

const model = {
    doInsert: (data) => service.doInsert(data),
    doUpdate: (id, data) => service.doUpdate(id, data),
    doDelete: (id) => service.doDelete(id),
}

export default model