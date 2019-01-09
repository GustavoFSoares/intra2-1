import http from '../client'

export default {
    getEletronicDocuments: (filter = {}) => {
        window.httpMessage = { show: true, error: "Erro ao buscar Documento" }
        return http.get(`/eletronic-documents/`, { params: filter }).then(res => res.data)
    },

    insert: (data) => {
        window.httpMessage = { show: true, success: `Documento <b>Inserido</b>`, error: "Documento <b>não Inserido</b>" }
        return http.post(`/eletronic-documents/`, data).then(res => res.data)
    },

    update: (id, data) => {
        window.httpMessage = { show: true, success: `Documento <b>#${id}</b> Atualizado`, error: "Documento <b>não Atualizado</b>" }
        return http.put(`/eletronic-documents/${id}`, data).then(res => res.data)
    },

    delete: (id) => {
        window.httpMessage = { show: true, success: `Documento <b>#${id}</b> Excluída`, error: "Documento <b>não Excluída</b>" }
        return http.delete(`/eletronic-documents/${id}`).then(res => res.data)
    },
    
}