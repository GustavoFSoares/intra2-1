import service from "@/services/cardapio"

export const getter = {
    getCardapioMenu: () => service.getCardapioMenu(),
}

const model = {
    doInsert: (data) => service.doInsert(data),
    doUpdate: (id, data) => service.doUpdate(id, data),
    doDelete: (id) => service.doDelete(id),

    mount(data) {
        let cardapio = JSON.parse(JSON.stringify(data))

        cardapio.data = new Date(cardapio.data)
        cardapio.data = `${cardapio.data.getDate() + 1}/${cardapio.data.getMonth() + 1}/${cardapio.data.getFullYear()}`
        
        return cardapio
    },

}

export default model