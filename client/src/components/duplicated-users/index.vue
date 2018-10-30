<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>
        <h3 v-html="subtitle"></h3>


        <div class="form-group form-row col">
            <input type="search" class="filter form-control" :disabled="!duplicatedUsers" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <alert-message v-if="alert" id="alert-message" :text="alert.text" :type="alert.type"/>
        <row>
            <div class="">
                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>Matrícula</th>
                        <th class="name1">Nome 1</th>
                        <th class="name2">Nome 2</th>
                        <th>Matrícula</th>
                        <th>Grupo</th>
                        <th>Duplicados</th>
                    </thead>
                    <tbody>
                        <tr v-for="(match, index) of searchList" v-bind:class="{'table-danger': match.rotine.id  == 0}" :key="match.id">
                            {{match.group}}
                            <td>{{ match.id }}</td>
                            <td>{{ match.user1.code }}</td>
                            <td class="name1">{{ match.user1.name }}</td>
                            <td class="name2">{{ match.user2.name }}</td>
                            <td>{{ match.user2.code }}</td>
                            <td>{{ match.user1.group.name }}</td>
                            <td>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-success" @click="isDuplicated(match, index)">
                                        <input type="radio" name="options"> Sim
                                    </label>
                                    <label class="btn btn-outline-danger" @click="notIsDuplication(match, index)">
                                        <input type="radio" name="options"> Não
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="duplicatedUsers.length == 0">
                            <td colspan="8"> Nenhum registro encontrado </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </row>

         <div id="buttons">
            <row>
                <router-link class="btn btn-outline-primary btn-lg" :to="'/usuario'" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import { FormRw, FormRws } from "@/components/shared/Form";
import AlertMessage from "@/components/shared/AlertMessage.vue";
import model, { getter } from "@/model/duplicated-users-model";

export default {
    data(){
        return {
            alert: '',
            duplicatedUsers: '',
            filter: '',
            subtitle: '',
            title: "Usuários Duplicados",
        }
    },
    methods: {
        isDuplicated(match, index) {
            model.checkDuplicated(match.id).then(res => {
                this.alert = { 'text': `${res.users} - ${res.message}`, 'type': res.status }
            })
            this.duplicatedUsers.splice(index, 1)
        },
        notIsDuplication(match, index) {
            model.checkLikeNotDuplication(match.id).then(res => {
                this.alert = { 'text': `Usuários não são compatíveis`, 'type': 'danger' }
            })
            this.duplicatedUsers.splice(index, 1)
        },
        loadValues() {
            getter.getDuplicatedUsers().then(res => { 
                this.duplicatedUsers = res
                if(res.length) {
                    let rotine = res[0].rotine
                    
                    this.subtitle = `<i><b>#${rotine.id}</b></i> - 
                        Integração <i><b>${moment(rotine.timeBegin.date).format('YYYY-MM-DD-hhmmss')}</b></i>
                        via <i><b>${rotine.from}</b></i>`
                }
            })
        },
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                return this.duplicatedUsers.filter(match => {
                    if( exp.test(match.user1.group.name)) {
                        return exp
                    } else if( exp.test(match.user1.id)) {
                        return exp
                    } else if( exp.test(match.user2.id)) {
                            return exp
                    } else if( exp.test(match.user1.name)) {
                        return exp
                    } else if( exp.test(match.user2.name)) {
                        return exp
                    } else if( exp.test(match.user1.code)) {
                        return exp
                    } else if( exp.test(match.user2.code)) {
                        return exp
                    }
                })
            } else {
                return this.duplicatedUsers
            }
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'alert-message': AlertMessage,
    },
    mounted() {
        this.loadValues()
    }
}
</script>

<style scoped>
    table {
        text-align: center;
    }

    .name1 {
        text-align: right;
    }

    .name2 {
        text-align: left;
    }

    #buttons {
        margin-top: 5%;
    }

    #alert-message {
        margin-left: 30%;
        margin-right: 30%;
    }
</style>
