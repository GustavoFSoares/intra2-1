import service from "@/services/login"

const doLogin = (user) => {
    alert(JSON.stringify(user))
    window.$session.start()
    let auth = doAuth(user)
    if(auth) {
        alert('logou')
        window.$session.set('user', { id: 'gustavo.soares', name: 'Gustavo Soares', group: 'ti', level: 2, admin: false })
    } else {
        alert('não deu')
    }
    
    if(window.lastRouteAccess) {
        window.location = window.lastRouteAccess
    } else {
        window.location = '/usuario'
    }
}

const doAuth = (user) => service.loginAuth(user)

const doLogout = () => {
    window.$session.destroy()
    window.location = '/'
}


export default {
    doLogin,
    doLogout
}