import http from '../client'

export default {
    getTypes: (filter = {}) => {
        window.httpMessage = { show: true, error: "Erro ao buscar <b>Tipo</b>" }
        return http.get(`/eletronic-documents/types/`, { params: filter }).then(res => res.data)
    },

    insert: (data) => {
        window.httpMessage = { show: true, success: `Tipo <b>Inserido</b>`, error: "Tipo <b>não Inserido</b>" }
        return http.post(`/eletronic-documents/types/`, data).then(res => res.data)
    },

    update: (id, data) => {
        window.httpMessage = { show: true, success: `Tipo <b>#${id}</b> Atualizado`, error: "Tipo <b>não Atualizado</b>" }
        return http.put(`/eletronic-documents/types/${id}`, data).then(res => res.data)
    },

    delete: (id) => {
        window.httpMessage = { show: true, success: `Tipo <b>#${id}</b> Excluída`, error: "Tipo <b>não Excluída</b>" }
        return http.delete(`/eletronic-documents/types/${id}`).then(res => res.data)
    },

}