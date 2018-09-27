const express = require('express')
const app = express()
const http = require('http').Server(app)
const io = require('socket.io')(http)

io.on('connection', (socket) => {
    socket.on('message', (res) => {
        return io.emit(`${res.id}/message`, { 'user': socket.username, 'message': res.msg, 'read': false, time: res.time }) }
    )
    socket.on('join', (res) => {
        if (res.username != null) {
            socket.username = res.username
        }
        // socket.broadcast.emit(`${res.id}/message`,
        //     { 'user': 'Server', 'message': socket.username + ' has joined!'})
    })
})

http.listen(3000, () => console.log('Running Socket IO on port 3000'))
