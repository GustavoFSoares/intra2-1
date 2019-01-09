import http from '../client'

export default {
    getStatus: (filter = {}) => {
        window.httpMessage = { show: true, error: "Erro ao buscar <b>Status</b>" }
        return http.get(`/eletronic-documents/status/`, { params: filter }).then(res => res.data)
    },

    insert: (data) => {
        window.httpMessage = { show: true, success: `Status <b>Inserido</b>`, error: "Status <b>não Inserido</b>" }
        return http.post(`/eletronic-documents/status/`, data).then(res => res.data)
    },

    update: (id, data) => {
        window.httpMessage = { show: true, success: `Status <b>#${id}</b> Atualizado`, error: "Status <b>não Atualizado</b>" }
        return http.put(`/eletronic-documents/status/${id}`, data).then(res => res.data)
    },

    delete: (id) => {
        window.httpMessage = { show: true, success: `Status <b>#${id}</b> Excluída`, error: "Status <b>não Excluída</b>" }
        return http.delete(`/eletronic-documents/status/${id}`).then(res => res.data)
    },

}