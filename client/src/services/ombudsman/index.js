import http from '../client'

export default  {
    getOmbudsmans: (filter = {}) => {
        window.httpMessage = { error: "Erro ao buscar <b>Ouvidorias</b>", show: true }
        return http.get('/ombudsman/', { params: filter }).then(res => res.data) },
    getOmbudsmansWaiting: (filter = {}) => {
        window.httpMessage = { error: "Erro ao buscar <b>Código</b>", show: true }
        return http.get('/ombudsman/waiting/', { params: filter }).then(res => res.data ) },

    insert: (demand) => {
        window.httpMessage = { success: "Ouvidoria <b>Inserida</b>", error: "Ouvidoria <b>não Inserida</b>", show: true }
        return http.post(`/ombudsman/`, demand).then(res => res.data) },

    update: (id, demand) => {
        window.httpMessage = { success: `Ouvidoria <b>#${id} Atualizada</b>`, error: "Ouvidoria <b>não Atualizada</b>", show: true }
        return http.put(`/ombudsman/:${id}`, demand).then(res => res.data)
    },

    delete: (id) => {
        window.httpMessage = { success: `Ouvidoria <b>#${id}</b> Excluído`, error: "Ouvidoria <b>não Atualizada</b>", show: true }
        return http.delete(`/ombudsman/:${id}`).then(res => res.data) },
}
