import axios from 'axios'

const client = axios.create({
    baseURL: `http://${window.location.hostname}:3001/`,
    withCredentials: false,
    headers: {
        'Accept': 'application/json',
        'Content-type': 'application/json'
    }
})

export default client
