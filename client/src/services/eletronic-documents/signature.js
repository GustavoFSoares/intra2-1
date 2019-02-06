import http from '../client'

export default {
    getUsersSignedByDocumentId: (id) => {
        window.httpMessage = { show: true, error: "Erro ao buscar <b>Usuários</b>" }
        return http.get(`/eletronic-documents/signature/users-signed/${id}`).then(res => res.data)
    },
    getNextUserToSignByDocumentId: (id) => {
        window.httpMessage = { show: true, error: "Erro ao buscar <b>Próxima Assinatura</b>" }
        return http.get(`/eletronic-documents/signature/next-signature/${id}`).then(res => res.data)
    },
    
}