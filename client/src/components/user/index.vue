<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <row>
            <input type="search" class="filter form-control" :disabled="!users" v-model="filter" placeholder="Pesquisa:"/>
        </row>

        <table v-if="users" class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th scope="col">Rede</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Level</th>
                    <th scope="col">Ramal</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user) of searchList" :key="user.id" v-bind:class="{'table-danger': user.active == '0'}">
                    <td>
                        <icon icon="chess-king" v-if="user.admin"/>
                        <icon icon="user-tie" v-if="user.complement"/>
                    </td>
                    <td scope="row">{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.occupation }}</td>
                    <td>{{ user.level }}</td>
                    <td>{{ user.ramal }}</td>
                    <td>
                        <icon class="text-success" icon="check-circle" v-if="user.active"/>
                        <icon class="text-danger" icon="times-circle" v-else/>
                    </td>
                    <td>
                        <router-link :to='`gerenciador/edit/${user.id}`' v-if="canShow(user)">
                            <icon icon="edit"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { getter } from '@/model/user-model'
export default {
    data() {
        return {
            title: '',
            users: [],
            user: $session.get('user'),
            filter: '',
        }
    },
    methods: {
        mounteUsers() {
            let groupId = this.$session.get('user').group.id
            this.title = this.$session.get('user').group.name
            getter.getUsersByGroupId(groupId).then(res => this.users = res)
        },
        canShow(user) {
            if(this.user.admin) {
                return true
            } else {
                return this.user.id == user.id ? true : false 
            }
        },
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                let list = ''
                return this.users.filter(user => {
                    if( exp.test(user.id)) {
                        return exp
                    } else if( exp.test(user.group.name)) {
                        return exp
                    } else if( exp.test(user.group.enterprise)) {
                        return exp
                    } else if( exp.test(user.ramal)) {
                        return exp
                    } else if( exp.test(user.name)) {
                        return exp
                    } else if( exp.test(user.occupation)) {
                        return exp
                    }
                })
            } else {
                return this.users
            }
        }
    },
    mounted() {
        this.mounteUsers()
    },
}
</script>

<style scoped>

</style>
