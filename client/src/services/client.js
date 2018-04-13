import axios from 'axios'

const client = axios.create({
    baseURL: 'http://localhost:3001/',
    withCredentials: false,
    headers: {
        'Accept': 'application/json',
        'Content-type': 'application/json'
    }
})

export default client
