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
    uploadFile: (file, fileName, prefix) => {
        window.httpMessage = { show: true, success: `Arquivo <b>Adicionado</b>`, error: "Arquivo <b>não Adicionado</b>" }
        return http.post('/eletronic-documents/file/', file, { params: { 'name': fileName, 'prefix': prefix } }).then(res => res.data)
    },

    update: (id, data) => {
        window.httpMessage = { show: true, success: `Documento <b>#${id}</b> Atualizado`, error: "Documento <b>não Atualizado</b>" }
        return http.put(`/eletronic-documents/${id}`, data).then(res => res.data)
    },
    signDocument: (id, type, data) => {
        window.httpMessage = { show: true, success: `Documento <b>#${id}</b> Assinado`, error: "Documento <b>não Assinado</b>" }
        return http.put(`/eletronic-documents/sign/${type}/${id}`, data).then(res => res.data)
    },
    updateAmendment: (id, data) => {
        window.httpMessage = { show: true, success: `Emendas <b>Adicionadas</b>`, error: "Emendas <b>não Adicionadas</b>" }
        return http.put(`/eletronic-documents/amendment-update/${id}`, data).then(res => res.data)
    },

    delete: (id) => {
        window.httpMessage = { show: true, success: `Documento <b>#${id}</b> Excluída`, error: "Documento <b>não Excluída</b>" }
        return http.delete(`/eletronic-documents/${id}`).then(res => res.data)
    },
    
}