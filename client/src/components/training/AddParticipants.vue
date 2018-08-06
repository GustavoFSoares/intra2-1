<template>
    <div class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <row>
            <div class="row">
                <rows :label="subtitles.user.name" class="col-md-7">
                    <v-select v-model="userSelected" label="name" :options="(users)"/>
                </rows>
                <rows :label="subtitles.user.code">
                    <v-select v-model="userSelected" label="code" :options="(users)"/>
                </rows>
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
import { FormRw, FormRws, Checkbox,  VueSelect } from "@/components/shared/Form";
import DatePicker from "@/components/shared/Form/DatePicker.vue";
import UserCard from './UserCard.vue';
import model, { getter } from "@/model/training-model";
import ParticipantList from "@/entity/training/participant-list";

export default {
    data(){
        return {
            id: '',
            title: "",
            users: [],
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
            getter.getUserById(user.id).then(res => this.users.push(res))
        },
        submit() {
            model.addParticipants(this.id, this.participantList).then(res => {
                this.$router.go('-1')
            }).catch(err => {
                console.log("Erro!", err)
            })
        },
        loadValues() {
            this.id = this.$route.params.id
            
            getter.getTrainingById(this.id).then(res => this.title = `${res.name} (${res.timeTraining})`)
            getter.getParticipantsTraining(this.id).then(res => this.participantList = res)
            getter.getUsers().then(res => this.users = res)
        },
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'v-select': VueSelect,
        'user-card': UserCard,
        'checkbox': Checkbox,
    },
    mounted() {
        this.loadValues()
    }
}
</script>

<style scoped>
    #buttons {
        margin-top: 5%;
    }

    .line {
        margin-top: 15px;
    }

    .row {
        margin-top: 15px;
    }
</style>
