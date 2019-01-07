import http from '../client'

export default  {
    getOmbudsmans: (filter = {}) => {
        window.httpMessage = { error: "Erro ao buscar <b>Ouvidorias</b>", show: true }
        return http.get('/ombudsman/', { params: filter }).then(res => res.data) },
    getOmbudsmansWaiting: (filter = {}) => {
        window.httpMessage = { error: "Erro ao buscar <b>Código</b>", show: true }
        return http.get('/ombudsman/waiting/', { params: filter }).then(res => res.data ) },
    getPermission: (params) => {
        window.httpMessage = { error: "Erro ao buscar <b>Permissões</b>", show: true }
        return http.get('/ombudsman/permission/', { params: params }).then(res => res.data)
    },
    getChatsByOmbudsman: (filter = { }) => {
        window.httpMessage = { error: "Erro ao buscar <b>Mensagens</b>", show: true }
        return http.get(`/ombudsman/messages/`, { params: filter }).then(res => res.data)
    },

    insert: (demand) => {
        window.httpMessage = { success: "Ouvidoria <b>Inserida</b>", error: "Ouvidoria <b>não Inserida</b>", show: true }
        return http.post(`/ombudsman/`, demand).then(res => res.data) },
    insertMessage: (data) =>{
        window.httpMessage = { error: "Mensagem <b>não Enviada</b>", show: true }
        http.post(`/ombudsman/messages/`, data).then(res => res.data) },
    uploadFile: (file, name) => { 
        window.httpMessage = { success: `Arquivo <b>#${name} salvo!</b>`, error: "Arquivo <b>não Salvo</b>", show: true }
        return http.post('/ombudsman/file/', file, { params: { 'name': name} }).then(res => res.data)
    },
        
    update: (id, ombudsman) => {
        window.httpMessage = { success: `Ouvidoria <b>#${id} Atualizada</b>`, error: "Ouvidoria <b>não Atualizada</b>", show: true }
        return http.put(`/ombudsman/${id}`, ombudsman).then(res => res.data) },
    setManagerResponse: (id, response) => {
        window.httpMessage = { success: `Relato adicionado <b>#${id}</b>`, error: "Relato <b>não adicionado</b>", show: true }
        return http.put(`/ombudsman/manager-response/${id}`, response).then(res => res.data) },
    setOmbudsmanResponse: (id, response) => {
        window.httpMessage = { success: `Relato adicionado <b>#${id}</b>`, error: "Relato <b>não adicionado</b>", show: true }
        return http.put(`/ombudsman/ombudsman-response/${id}`, response).then(res => res.data) },
    addManager: (id, user, type) => {
        window.httpMessage = { success: `Resposável <b>Adicionado</b>`, error: "Usuário já cadastrado", show: true }
        return http.put(`/ombudsman/add-manager/${id}/${type}`, user, ).then(res => res.data )},
    removeManager: (id, user, type) => {
        window.httpMessage = { error: "Responsável <b>Não Removido</b>", show: true }
        return http.put(`/ombudsman/remove-manager/${id}/${type}`, user, ).then(res => res.data )},
    closeChat: (id, ombudsman) => {
        window.httpMessage = { success: `Ouvidoria <b>${id} Fechada</b>`, error: "Ouvidoria <b>Não Fechada</b>", show: true }
        return http.put(`/ombudsman/close-chat/${id}`, ombudsman ).then(res => res.data )},
    finishOmbudsman: (id, ombudsman) => {
        window.httpMessage = { success: `Ouvidoria <b>${id} Finalizada</b>`, error: "Ouvidoria <b>Não Finalizada</b>", show: true }
        return http.put(`/ombudsman/finish/${id}`, ombudsman ).then(res => res.data )},

    delete: (id) => {
        window.httpMessage = { success: `Ouvidoria <b>#${id}</b> Excluído`, error: "Ouvidoria <b>não Excluída</b>", show: true }
        return http.delete(`/ombudsman/${id}`).then(res => res.data) },
}
