import http from '../client'

export default  {
    getFile: (file) =>
        http.get(`/file/`, { params: { 'filePath': file } }).then(res => res.data),
}
