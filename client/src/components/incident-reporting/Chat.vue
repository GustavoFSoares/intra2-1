<template>
    <div>
        <div v-if="state == 0">
        <h3>Welcome! Please choose a username</h3>
        <form @submit.prevent="setUsername">
            <input type="text" placeholder="Username..." v-model="username" />
            <input type="submit" value="Join" />
        </form>
        <button @click="continueWithoutUsername">Join as a Guest</button>
        </div>
        <div v-if="state == 1">
        <ul id="chatbox">
            <li v-for="(message, index) in messages" :key="index">
                <b>{{ message.user }}:</b> {{ message.message }}
            </li>
        </ul>
        <form @submit.prevent="sendMessage">
            <input type="text" placeholder="Message..." v-model="message" />
            <input type="submit" value="Send" />
        </form>
        </div>
    </div>
</template>

<script>
var socket
const io = require('socket.io-client')
export default {
    data() {
        return {
            messages: [],
            message: '',
            username: '',
            state: 0
        }
    },
    methods: {
        sendMessage: function () {
          socket.emit('message', this.message);
          this.message = '';
        },
        setUsername: function () {
          socket.emit('join', this.username);
          this.username = '';
          this.state = 1;
        },
        continueWithoutUsername: function () {
          socket.emit('join', null);
          this.state = 1;
        }
      },
      created: function () {
        socket = io('http://localhost:3000');
      },
      mounted() {
        socket.on('message', (message) => {
          this.messages.push(message);
        //   // this needs to be done AFTER vue updates the page!!
        //   this.$nextTick(function () {
        //     var messageBox = document.getElementById('chatbox');
        //     messageBox.scrollTop = messageBox.scrollHeight;
        //   });
        });
      }
}
</script>

<style scoped>
    body {
    font-family: sans-serif;
    background: url('http://www.cornwallnewswatch.com/wp-content/uploads/2014/07/Fire-01.jpg');
    color: white;
    }

    #chatbox {
    height: 200px;
    max-width: 400px;
    overflow-y: scroll;
    }
</style>
