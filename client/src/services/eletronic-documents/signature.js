import http from '../client'

export default {
    getUsersForDocument: (id) => {
        window.httpMessage = { show: true, error: "Erro ao <b>Usuários</b>" }
        return http.get(`/eletronic-documents/signature/users-of-document/${id}`, ).then(res => res.data)
    },
}