<template>
    <div id="screen">
        <div class="container mb-5" @keyup.enter="findUserByName()">
            <h1>{{ title }}</h1>

            <div class='row'>
                <rows label='' class='col-md-8'>
                    <input type="search" class="form-control" v-model="find.userFinderName"  placeholder="Nome do Gestor:"/>    
                </rows>
                <rows label=''>
                    <button @click="findUserByName()" class="btn btn-outline-primary" :disabled="!find.userFinderName || find.finding">
                        Pesquisar
                        <icon v-if="find.finding" icon="spinner" pulse/>
                    </button>
                </rows>
            </div>
        </div>
            
        <row>
            <div id="alert-message">
                <alert-message v-if="alertMessage" :type="alertMessage.type" :text="alertMessage.text"/>
            </div>
        </row>

        <div class="container-fluid">
            <!-- <div class="form-group form-row col">
                <input type="search" class="filter form-control" :disabled="!values.users" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
            </div> -->

            <div id="table" class="list-group">
                
                <div v-for="(user, index) of searchList" :key="user.id" class="card">
                    <router-link to="" class="text-left list-group-item list-group-item-action" data-toggle="collapse" :data-target="'#id-'+index" aria-expanded="true">
                        {{ user.name }} ({{ user.group.name }})
                    </router-link>

                    <div :id="'id-'+index" class="collapse" data-parent="#table">
                        <div class="card-body">
                            
                            <div class='row'>
                                <rows label='Gestor'>
                                    <checkbox id="admin" class="button" v-model="user.admin"/>    
                                </rows>
                                <rows label="Email">
                                    <input data-vv-as="Email" v-validate data-vv-rules="required|email" type="text" class="form-control" name="User-email" v-model="user.email">
                                    <require-text :error="errors.has('User-email')" :text="errors.first('User-email')" :show="true" :attribute="user.email"/>
                                </rows>
                            </div>
                            
                        </div>
                        
                        <div class="card-body">
                            <row>
                                <button class="btn btn-outline-primary" @click="updateUser(user)" :disabled="sending">Atualizar</button>
                            </row>
                        </div>
                    </div>

                </div>
                
                 <div class="card" v-if="values.users.length == 0 && values.users">
                    <a class="btn text-left" dissabled>
                        Nenhum usuário encontrado
                    </a>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import { FormRw, FormRws, Require, Checkbox } from "@/components/shared/Form"
import AlertMessage from "@/components/shared/AlertMessage.vue"
import AddUser from "./AddUser.vue"
import model, { getter } from '@/model/user-model'
import User from "@/entity/User"

export default {
    data() {
        return {
            title: 'Responsavel por Setor',
            groupId: '',
            sending: false,
            values: {
                users: [],
            },
            filter: '',
            find: {
                finding: false,
                userFinderName: null,
            },
            alertMessage: ''
        }
    },
    methods: {
        loadUserForGroup(groupId) {
            this.groupId = groupId
            this.values.users = ''
        },
        findUserByName() {
            this.find.finding = true

            getter.getUserByName(this.find.userFinderName).then(res => { 
                this.values.users = []
                
                res.forEach(user => {
                    this.values.users.push(new User(user))
                })
                this.find.userFinderName = null
                this.find.finding = false
            })
        },
        updateUser(user) {
            this.sending = true
            model.doEditUser(user.id, user).then( res => {
                this.alertMessage = { text: `Usuário <b>${user.id}</b> foi atualizado`, type:"success" }
                this.sending = false
                window.scrollTo(0, 100)
            }, err => {
                this.sending = false
                this.$alert.danger('Erro ao atualizar o gestor')
                this.$router.go()
            })
        },
        submit() {
            model.doEditUsers(this.values.users).then(res => {
                this.$router.go()
            })
        }

    },
    mounted() {
        getter.getUsersAdminWithEmail().then(res => {
            res.forEach(user => this.values.users.push(new User(user)) );
        })
    },
    computed: {
        searchList() {

            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                return this.values.users.filter(user => {
                    
                    if( exp.test(user.id)) {
                        return exp
                    } else if( exp.test(user.name)) {
                        return exp
                    } else if( exp.test(user.group.name)) {
                        return exp
                    }
                })
            } else {
                return this.values.users
            }
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
        'checkbox': Checkbox,
        'add-user-modal': AddUser,
        'alert-message': AlertMessage,
    }
}
</script>

<style scoped>
    #table div {
        margin-top: 2px;
    }

    #alert-message {
        margin-left: 35%;
        margin-right: 35%;
        text-align: center;
    }
</style>
