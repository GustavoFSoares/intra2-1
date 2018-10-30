<template>
    <div class="container">
        <h1>{{ title }}</h1>
        <h2 v-if="training.done" class="finished"><i>(Treinamento Finalizado)</i></h2>

        <row>
            <div id="users-filter" @keyup.enter="loadUsers()">
                <div class="search-area container-fluid">
                    <div class='row'>
                        <input id="filter-input" class="form-control col-10" placeholder="Nome ou Matrícula" type="search" v-model="userFilter">
                        <button id="filter-button" class="btn btn-outline-primary" @click="loadUsers()">
                            Buscar
                        </button>
                        <icon v-if="loading" id="icon" icon="circle-notch" spin/> 
                    </div>
                </div>
            
                
                <div id="users-loaded" v-if="users">
                    <div class="row">
                        <rows :label="subtitles.user.name" class="col-md-7" >
                            <v-select v-model="userSelected" label="name" :options="(users)" :disabled="training.done"/>
                        </rows>
                        <rows :label="subtitles.user.code">
                            <v-select v-model="userSelected" label="code" :options="(users)" :disabled="training.done"/>
                        </rows>
                    </div>
                </div>
            </div>

            <div>
                <user-card v-if="userSelected" :user="userSelected" icon="add" @added="addUser(userSelected)"/>
            </div>
        </row>

        <row>
            <div class="container">
                <table class="table table-striped">
                    <thead>
                        <th></th>
                        <th></th>
                        <th>Matrícula</th>
                        <th>Nome</th>
                        <th>Setor</th>
                        <th>Cargo</th>
                        <th>Presença</th>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) of participantList" :key="index">
                            <td>
                                <router-link @click.native="removeUser(user, index)" to="" v-if="user.isAdded"><icon class="float-right" icon="minus"/></router-link>
                            </td>
                            <td> <icon icon="user-graduate" v-if="user.student"/> </td>
                            <td>{{ user.code.substring(0,8) }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.occupation }}</td>
                            <td>{{ user.GroupName }}</td>
                            <td>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-success" v-bind:class="{ 'active' : user.presence }" @click="user.presence = true">
                                        <input type="radio" name="options"> Sim
                                    </label>
                                    <label class="btn btn-outline-danger" v-bind:class="{ 'active' : !user.presence }" @click="user.presence = false">
                                        <input type="radio" name="options"> Não
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </row>

         <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="submit">
                    Confirmar Lista
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'hht'}" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import { FormRw, FormRws, VueSelect } from "@/components/shared/Form";
import UserCard from './UserCard.vue';
import { getter } from "@/model/training-model";
const ModelUserGetter = require("@/model/user-model").getter
const ModelTrainingParticipant = require("@/model/training-participant-model")
import ParticipantList from "@/entity/training/participant-list";
import Training from "@/entity/training";

export default {
    data(){
        return {
            id: '',
            title: "",
            users: '',
            loading: '',
            userFilter: '',
            training: '',
            userSelected: '',
            participantList: '',
            subtitles: {
                user: { name: "Participante", code: "Matrícula" },
            },
        }
    },
    methods: {
        addUser(user) {
            user.isAdded = true
            this.participantList.push(new ParticipantList(user))

            let id = this.users.indexOf(user)
            
            this.userSelected = ''
            this.users.splice(id, 1)
        },
        removeUser(user, index) {
            this.participantList.splice(index, 1)
            ModelUserGetter.getUserById(user.id).then(res => this.users.push(res))
        },
        submit() {
            ModelTrainingParticipant.default.addParticipants(this.id, this.participantList).then(res => {
                this.$router.go('-1')
            }).catch(err => {
                console.log("Erro!", err)
            })
        },
        loadValues() {
            this.id = this.$route.params.id
            
            getter.getTrainingById(this.id).then(res => { 
                    this.title = `${res.name} (${moment(res.beginTime.date).format('DD/MM/YYYY - HH:mm')})`
                    this.training = new Training(res)
                })
            ModelTrainingParticipant.getter.getParticipantsTraining(this.id).then(res => this.participantList = res)
        },
        loadUsers() {
            if(this.userFilter) {
                this.loading = true
                ModelUserGetter.getUsersByNameOrCode(this.userFilter).then(res => { 
                    this.userFilter = ''
                    this.users = res
                    this.training.instructor = ''
                    this.loading = false
                }, err => {
                    console.log(err);
                    this.userFilter = 'Erro ao realizar busca'
                    this.loading = false
                })
            }
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'v-select': VueSelect,
        'user-card': UserCard,
    },
    mounted() {
        this.loadValues()
    }
}
</script>

<style scoped>
     #users-loaded {
        margin-top: 20px;
    }

    #users-filter {
        margin-left: 2%;
        margin-right: 2%;
    }
    
    #users-filter .search-area {
        margin-left: 3%;
        margin-right: 3%;
    }

    #users-filter #filter-button {
        margin-left: 20px;
        float: left
    }
    
    #users-filter #icon {
        font-size: 30px;
        margin-top: 4px;
        margin-left: 10px;
        /* float:left; */
    }

    #buttons {
        margin-top: 5%;
    }

    .line {
        margin-top: 15px;
    }

    .row {
        margin-top: 15px;
    }

    .finished {
        color: red;
    }
</style>
