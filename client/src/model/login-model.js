import service from "@/services/login"

const doLogin = (user) => {
    
    doAuth(user).then(res => {
        if(res.status) {
            window.$session.start()
            window.$session.set('user', res.user)
        }

        if (window.lastRouteAccess) {
            window.location = window.lastRouteAccess
        } else {
            window.location = '/usuario'
        }
    })

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