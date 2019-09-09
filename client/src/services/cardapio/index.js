import http from '../client'

export default {
    getCardapios: () => {
        window.httpMessage = { show: true, error: "Erro ao buscar Documento" }
        return http.get(`/cardapio/get/`).then(res => res.data)
    },
    getCardapioMenu: () => {
        return http.get(`/cardapio/menu/`).then(res => res.data)
    },

    doInsert: (data) => {
        return http.post(`/cardapio/`, data).then( res => res.data )
    },

    doUpdate: (id, data) => {
        return http.put(`/cardapio/${id}`, data).then( res => res.data )
    },

    doDelete: (id) => {
        return http.delete(`/cardapio/${id}`).then( res => res.data )
    }
}