import http from '../client'

export default {
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