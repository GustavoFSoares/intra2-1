import service from "@/services/cardapio"

export const getter = {
    getCardapioMenu: () => service.getCardapioMenu(),
}

const model = {
    doInsert: (data) => service.doInsert(data),
    doUpdate: (id, data) => service.doUpdate(id, data),
    doDelete: (id) => service.doDelete(id),

    mount(data, dateCardapio) {
        let cardapio = JSON.parse(JSON.stringify(data))

        cardapio.data = new Date(cardapio.data)

        if (typeof dateCardapio == 'string') {
            let date = dateCardapio.split('-')
            console.log(date)
            dateCardapio = new Date(date[0], date[1] - 1, date[2])
        }

        let day = dateCardapio.getDate();
        let month = dateCardapio.getMonth();
        let year = dateCardapio.getFullYear();
        
        cardapio.data.setDate(day)
        cardapio.data.setMonth(month)
        cardapio.data.setFullYear(year)

        cardapio.data = `${cardapio.data.getDate()}/${cardapio.data.getMonth() + 1}/${cardapio.data.getFullYear()}`
        
        return cardapio
    },

}

export default model