<template>
    <div class='container'>

        <div class="row">
            <div id="chatbox">
                <div class="chat" v-for="(chat, index) of chats" :key="index">
                    <div class="card anotherchat" v-bind:class="{'youchat':chat.user==user}" @mouseover="chat.read = true">
                        <div class="card-body">
                            <blockquote class="content-chat">
                                <h5 v-if="chat.user!=user" class="card-title">
                                    {{ chat.user }}
                                    <icon class="icon text-warning float-right" icon="exclamation-triangle" v-if="!chat.read"/>
                                </h5>
                                <p class="card-text">{{ chat.message }}</p>
                            </blockquote>
                            <footer class="time blockquote-footer text-right">
                                {{ moment(chat.time.date).format('DD/MM/YYYY HH:mm') }}
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sendMessage-box" class="row">
            <div class="col-md-10" id="sendMessage-content">
                <textarea v-model="message" line="10" class="form-control" @click="readAllMessages()" :disabled="chats == null" placeholder="Escreva seu relato:"/>
            </div>
            <div class="col-md" id="sendMessage-button">
                <router-link to="" class="btn btn-outline-secondary btn-lg" tag="button" @click.native="setMessage()" :disabled="!this.message">
                    Enviar
                </router-link>
            </div>
        </div>
               

    </div>
</template>

<script>
var socket
import moment from "moment";
import model, { getter } from "@/model/incident-reporting-model";
import Socket from "@/model/chat-model";
import { FormRw, FormRws, VueSelect } from "@/components/shared/Form";

export default {
    data() {
        return {
            message: '',
            user: this.$session.get('user').name,
            socket: null,
            moment: moment,
            chats: null
        }
    },
    props: {
        id: '',
    },
    methods: {
        setMessage: function () {
            model.sendMessage(this.$route.params.id, this.message)
            this.message = '';
        },
        doScroll() {
            setTimeout(() => {
                let chatbox = document.getElementById("chatbox");
                    if(chatbox) {
                        chatbox.scrollTop = chatbox.scrollHeight;
                    }
            }, 0);
        },
        readAllMessages() {
            this.chats.forEach(chat => {
                chat.read = true
            });
        }        
    },
    comments: {
        'row': FormRw,
        'rows': FormRws,
    },
    created: function () {
        getter.getChatsByIncident(this.$route.params.id).then(res => { this.chats = res; this.doScroll() })
        
        this.socket = new Socket(this.id, this.user)
        model.socketInit(this.socket)
    },
    mounted() {
        this.socket.io.on(`${this.id}/message`, (message) => {
           this.socket.isYou(message.user) ? message.read = true : ''
            
            this.chats.push(message);
            this.doScroll()
        });
    }
}
</script>

<style lang="scss" scoped>
    #chatbox {
        width: 100%;
        height: 300px;
        overflow-y: scroll;
    }

    .chat {
        margin-top: 10px;
        border-radius: 10px;
        display: flex;
    }

    .anotherchat {
        margin-right: 30%;    
        margin-left: 0%;
        background-color: rgba(206, 206, 206, 0.329);
    }

    .youchat {
        margin-right: 5px;
        margin-left: auto;
        max-width: 80%;
        background-color: rgba(197, 241, 185, 0.514);
    }

    #sendMessage-box {
        margin-top: 20px;
    }
    
    #sendMessage-button {
        margin-top: 5px;
    }

    .icon {
        margin-left: 15px;
    }
</style>
