const io = require('socket.io-client')
const Socket = class {
    constructor(id, userName) {
        this.id = id
        this.userName = userName
        this.io = io(`http://${window.location.hostname}:3000`);
        this.setUserName(userName)
    }

    setUserName(user) {
        this.io.emit('join', { 'id': this.id, 'username': user, 'time': { date: new Date() } });
    }
    sendMessage(message) {
        this.io.emit('message', { 'id': this.id, 'msg': message, 'time': { date: new Date() } });
    }
    isYou() {
        return window.$session.get('user').name == this.userName ?
            true : false
    }
}
export default Socket