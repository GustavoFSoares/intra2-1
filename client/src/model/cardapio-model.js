import service from "@/services/cardapio"

export const getter = {
    getCardapioMenu: () => service.getCardapioMenu(),
    getCardapios: () => service.getCardapios(),
    getCardapioById: (id) => service.getCardapioById({ 'id': id }),
}

const model = {
    doInsert: (data) => service.doInsert(data),
    doUpdate: (cardapio) => service.doUpdate(cardapio.id, cardapio),
    doDelete: (id) => service.doDelete(id),

    mount(data) {
        let cardapio = JSON.parse(JSON.stringify(data))

        cardapio.data = new Date(cardapio.data)
        cardapio.data = `${cardapio.data.getDate() + 1}/${cardapio.data.getMonth() + 1}/${cardapio.data.getFullYear()}`
        
        return cardapio
    },

}

export default model