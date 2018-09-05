<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <div class="form-group form-row col">
            <input type="search" class="filter form-control" :disabled="!values.groups" @input="filter = $event.target.value" placeholder="Nome:"/>
        </div>

        <div id="table" class="list-group">
            <div v-for="group of searchList" :key="group.id" class="card">

                <router-link to="" class="text-left list-group-item list-group-item-action" data-toggle="collapse" :data-target="'#id'+group.id" aria-expanded="true" :aria-controls="'id'+group.id" @click.native="loadUserForGroup(group.id)">
                    {{ group.name }}
                </router-link>

                <div :id="'id'+group.id" class="collapse" data-parent="#table">
                    <div class="card-body">

                        <div id="users" v-if="group.id == groupId">
                            <div class="card" v-for="(user, index) in values.users" :key="`g${group.id}u${index}`" >
                                <a class="btn text-left" :id="`g${group.id}u${index}`"  data-toggle="collapse" :data-target="`#g${group.id}u${index}-value`" aria-expanded="true" :aria-controls="`g${group.id}u${index}-value`" v-bind:class="{'table-secondary': !user.admin}">
                                    {{ user.name }}
                                </a>

                                <div :id="`g${group.id}u${index}-value`" class="collapse" :aria-labelledby="`g${group.id}u${index}`" data-parent="#users">
                                    <div class="card-body">

                                        <div class='row'>
                                            <rows label='Administrador'>
                                                <checkbox @changed="user.admin = !user.admin" id="admin" class="button" :checked="user.admin"/>    
                                            </rows>
                                            <rows label="Email">
                                                <input data-vv-as="Email" v-validate data-vv-rules="required|email" type="text" class="form-control" name="User-email" v-model="user.email">
                                                <require-text :error="errors.has('User-email')" :text="errors.first('User-email')" :show="true" :attribute="user.email"/>
                                            </rows>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card" v-if="values.users.length == 0 && values.users">
                                <a class="btn text-left" dissabled>
                                    Nenhum usuário encontrado
                                </a>
                            </div>

                            <row>
                                <button class="btn btn-outline-primary" @click="submit()">Atualizar</button>
                                <button class="btn btn-default" @click="$refs.addUser.openModal(group.id)">Adicionar Novo</button>
                            </row>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
        <add-user-modal ref="addUser" :group="groupId" @close="addToUsers"/>

    </div>
</template>

<script>
const ModelGroup = require('@/model/group-model').getter
import { FormRw, FormRws, Require, Checkbox } from "@/components/shared/Form";
import AddUser from "./AddUser.vue";
import model, { getter } from '@/model/user-model'
import User from "@/entity/User";
import moment from 'moment'

export default {
    data() {
        return {
            title: 'Responsavel por Setor',
            groupId: '',
            values: {
                groups: [],
                users: [],
            },
            moment: moment,
            filter: '',
        }
    },
    methods: {
        loadValues() {
            ModelGroup.getGroups().then(res => {this.values.groups = res })
        },
        loadUserForGroup(groupId) {
            this.groupId = groupId
            this.values.users = ''

            model.loadUsers(this.groupId).then(res => this.values.users = res)
        },
        addToUsers(user) {
            this.values.users.push(new User(user))
        },
        submit() {
            model.doEditUsers(this.values.users).then(res => {
                this.$router.go()
            })
        }

    },
    mounted() {
        this.loadValues()
    },
    computed: {
        searchList() {

            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                return this.values.groups.filter(groups => {
                    
                    if( exp.test(groups.id)) {
                        return exp
                    } else if( exp.test(groups.name)) {
                        return exp
                    }
                })
            } else {
                return this.values.groups
            }
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
        'checkbox': Checkbox,
        'add-user-modal': AddUser,
    }
}
</script>

<style scoped>
    #table div {
        margin-top: 2px;
    }
</style>
