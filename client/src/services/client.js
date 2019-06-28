import axios from 'axios'

const client = axios.create({
    baseURL: `http://${window.location.hostname}:3001/`,
    withCredentials: false,
    headers: {
        'Access-Control-Allow-Origin': '*',
        'Accept': 'application/json',
        'Content-type': 'application/json'
    },
})

client.interceptors.response.use(response => {
    if(window.httpMessage) {
        if (window.httpMessage.success && window.httpMessage.show) {
            window.httpMessage.show = false
            window.$alert.success(window.httpMessage.success)
            window.httpMessage = ''
        }
    }

    return response;
}, error => {
    if(window.httpMessage) {
        if (window.httpMessage.error && window.httpMessage.show) {
            window.httpMessage.show = false
            window.$alert.danger(window.httpMessage.error)
            window.statusMessage = ''
        }
    }
    Promise.reject(error);
});

export default client
