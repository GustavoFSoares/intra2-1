import service from "@/services/login"

const doLogin = (user) => {
    
    return doAuth(user).then(res => res )

}

const doAuth = (user) => service.loginAuth(user)

const doLogout = () => {
    window.$session.destroy()
    window.location = '/'
}


export default {
    doLogin,
    doLogout,
    doAuth,
}