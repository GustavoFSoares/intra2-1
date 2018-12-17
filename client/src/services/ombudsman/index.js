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

    insert: (demand) => {
        window.httpMessage = { success: "Ouvidoria <b>Inserida</b>", error: "Ouvidoria <b>não Inserida</b>", show: true }
        return http.post(`/ombudsman/`, demand).then(res => res.data) },
        
    update: (id, demand) => {
        window.httpMessage = { success: `Ouvidoria <b>#${id} Atualizada</b>`, error: "Ouvidoria <b>não Atualizada</b>", show: true }
        return http.put(`/ombudsman/${id}`, demand).then(res => res.data) },
    setManagerResponse: (id, response) => {
        window.httpMessage = { success: `Relato adicionado <b>#${id}</b>`, error: "Relato <b>não adicionado</b>", show: true }
        return http.put(`/ombudsman/manager-response/${id}`, response).then(res => res.data) },
    setOmbudsmanResponse: (id, response) => {
        window.httpMessage = { success: `Relato adicionado <b>#${id}</b>`, error: "Relato <b>não adicionado</b>", show: true }
        return http.put(`/ombudsman/ombudsman-response/${id}`, response).then(res => res.data) },
    addManager: (id, user) => {
        window.httpMessage = { success: `Resposável <b>Adicionado</b>`, error: "Responsável <b>não adicionado</b>", show: true }
        return http.put(`/ombudsman/add-manager/${id}`, user).then(res => res.data) },

    delete: (id) => {
        window.httpMessage = { success: `Ouvidoria <b>#${id}</b> Excluído`, error: "Ouvidoria <b>não Excluída</b>", show: true }
        return http.delete(`/ombudsman/${id}`).then(res => res.data) },
}
