<template>
    <div @keyup.enter="findUserByName()">
        
        <label>{{ title }}:</label>
        <row>
            <div class='row'>
                <rows label='' class='col-md-8'>
                    <input type="search" class="form-control" v-model="nameFinded"  placeholder="Nome:"/>    
                </rows>
                <rows label=''>
                    <button @click="findUserByName()" class="btn btn-outline-primary" :disabled="!canFind">
                        Pesquisar
                        <icon v-if="finding" icon="spinner" pulse/>
                    </button>
                </rows>
            </div>
            <div class="container">
                <row label='Selecione um usário' v-if="users.length">
                    <v-select label="name" :options="(users)" v-model="userSelected" @input="addUser()"/>
                </row>
                
                <div :id="componentKey+'table'" class="list-group">
                    <div v-for="(user, index) in usersSelected" :key="index" class="card">

                        <router-link to="" class="text-left list-group-item list-group-item-action" data-toggle="collapse" :data-target="`#id${user.id.substr(0, 3)}${index}${componentKey}`" aria-expanded="true" :aria-controls="`id${user.id.substr(0, 3)}${index}${componentKey}`">
                            <span class="float-left">{{ user.name }}</span>
                            <router-link class="float-right" to="" @click.native="removeUser(user, index)">
                                <icon class="text-danger" icon="minus-circle"/>
                            </router-link>
                        </router-link>

                        <div :id="`id${user.id.substr(0, 3)}${index}${componentKey}`" class="collapse" :data-parent="'#'+componentKey+'table'">
                            <div class="card">
                                <div class="card-body">
                                    <span class="float-left">
                                        <div class="group">
                                            <span><b>Setor: </b>{{ user.group.name }}</span>
                                        </div>
                                        <div class="occupation">
                                            <span><b>Cargo: </b>{{ user.occupation }}</span>
                                        </div>
                                        <div class="email">
                                            <span class="float-left" v-if="user.email"><b>Email: </b> {{ user.email }}</span>
                                            <span class="float-left" v-else><b>Sem email cadastrado</b></span>                                
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </row>
    </div>
</template>

<script>
import { getter } from "@/model/user-model";
export default {
    data: () => ({
        users: [],
        userSelected: '',
        usersSelected: [],
        nameFinded: '',
        finding: false,
        componentKey: '',
        noResult: false,
    }),
    props: {
        value: '',
        title: { default: 'Adicionar Usuários' }
    },
    watch: {
        usersSelected() {
            this.$emit('input', this.usersSelected)
        },
        value() {
            if( this.usersSelected.length == 0 ) {
                this.usersSelected = this.value
            }
        }
    },
    methods: {
        findUserByName() {
            if(this.canFind) {
                
                this.noResult = false
                this.finding = true
                getter.getUserByName(this.nameFinded).then(res => { 
                    if(res.length === 0) {
                        this.noResult = true
                    }
                    
                    this.users = res
                    this.nameFinded = ''
                    this.finding = false
                }).catch(err => {
                    this.nameFinded = ''
                    this.finding = false
                })
            }
        },
        addUser() {
            if(this.userSelected) {
                if(!this.checkIfExistOnList(this.userSelected)) {
                    this.usersSelected.push(this.userSelected)
                    this.userSelected = ''
                    this.users = []
                } else {
                    this.$alert.warning(`Usuário já adicionado!`)
                }
            }
        },
        removeUser(user, index) {
            this.usersSelected.splice(index, 1)
        },
        checkIfExistOnList(userSelected) {
            return this.usersSelected.find(user => { 
                return user.id == userSelected.id
            })
        }
    },
    computed: {
        canFind() {
            if(!this.nameFinded || this.finding) {
                return false
            } else {
                return true
            }
        },
    },
    mounted() {
        this.componentKey = "c_key"+this._uid
        this.usersSelected = this.value
    }
}
</script>