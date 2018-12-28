import http from '../client'

export default  {
    getFile: (file) =>
        http.get(`/file/`, { params: { 'filePath': file } }).then(res => res.data),
    checkFileExist: (partialPath) => {
        window.httpMessage = { error: `Erro ao procurar arquivo em: <b>${partialPath}</b>`, show: true }
        return http.get(`/file/check-exist/?partialPath=${partialPath}`).then(res => res.data)
    },
}
