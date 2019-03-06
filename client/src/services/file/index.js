import http from '../client'

export default  {
    getFile: (file) =>
        http.get(`/file/`, { params: { 'filePath': file } }).then(res => res.data ),
    getFilesOfFolder: (id, origin) => {
        window.httpMessage = { error: `Erro ao procurar arquivos`, show: true }
        return http.get(`/${origin}/folder/${id}`).then(res => res.data )
    },
    checkFileExist: (partialPath) => {
        window.httpMessage = { error: `Erro ao procurar arquivo em: <b>${partialPath}</b>`, show: true }
        return http.get(`/file/check-exist/?partialPath=${partialPath}`).then(res => res.data)
    },

    removeFile: (folder, origin) => {
        window.httpMessage = { success: `Arquivo removido com sucesso`, error: `Arquivo não removido`, show: true }
        return http.put(`/${origin}/folder/${folder.id}`, { 'id': folder.id, 'file': folder.file }).then( res => res.data )
    }
}
