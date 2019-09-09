import http from '../client'

export default {
    getCardapioById: (filter = {}) => {
        window.httpMessage = { show: true, error: "Erro ao buscar Cardapio" }
        return http.get(`/cardapio/`, { params: filter }).then(res => res.data)
    },
    getCardapios: () => {
        window.httpMessage = { show: true, error: "Erro ao buscar Cardapios" }
        return http.get(`/cardapio/get/`).then(res => res.data)
    },
    getCardapioMenu: () => {
        return http.get(`/cardapio/menu/`).then(res => res.data)
    },

    doInsert: (data) => {
        return http.post(`/cardapio/`, data).then( res => res.data )
    },

    doUpdate: (id, data) => {
        window.httpMessage = { show: true, success: "Cardapio Atualizado", error: "Cardapio <b>não Atualizado</b>"  }
        return http.put(`/cardapio/${id}`, data).then( res => res.data )
    },

    doDelete: (id) => {
        return http.delete(`/cardapio/${id}`).then( res => res.data )
    }
}