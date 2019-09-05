var date = new Date()

export default class Cardapio {
    constructor(cardapio = {refeicao: 'ALMOÇO'}) {
        this.id = cardapio.id
        this.data = cardapio.data ? new Date(cardapio.data.date) : new Date(date.getFullYear(), date.getMonth(), date.getDate()).toLocaleDateString('en-za').replace(/\//g, "-")
        this.refeicao = cardapio.refeicao
        this.cardapio = cardapio.cardapio
    }
}