import http from '../client'

export default {
    getDemands: (filter = {}) => {
        window.httpMessage = { show: true, error: "Erro ao buscar Demandas" }
        return http.get(`/ombudsman/demands/`, { params: filter }).then(res => res.data) },

    insert: (demand) => { 
        window.httpMessage = { show: true, success: "Demanda <b>Inserida</b>", error: "Demanda <b>não Inserida</b>" }
        return http.post(`/ombudsman/demands/`, demand).then(res => res.data) },
    
    update: (id, demand) => { 
        window.httpMessage = { show: true, success: `Demanda <b>#${id}</b> Atualizada`, error: "Demanda <b>não Atualizada</b>" }
        return http.put(`/ombudsman/demands/${id}`, demand).then(res => res.data) },
    
    delete: (id) => { 
        window.httpMessage = { show: true, success: `Demanda <b>#${id}</b> Excluída`, error: "Demanda <b>não Excluída</b>" }
        return http.delete(`/ombudsman/demands/${id}`).then(res => res.data) },
}