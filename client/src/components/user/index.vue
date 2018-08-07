<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <table v-if="users" class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th scope="col">#</th>
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
                <tr v-for="(user, index) of users" :key="user.id" v-bind:class="{'table-danger': user.c_removed == '1'}">
                    <td>
                        <icon icon="chess-king" v-if="user.admin"></icon>
                    </td>
                    <td scope="row">{{ index }}</td>
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.occupation }}</td>
                    <td>{{ user.level }}</td>
                    <td>{{ user.ramal }}</td>
                    <td>
                        <icon class="text-success" icon="check-circle" v-if="!user.c_removed"/>
                        <icon class="text-danger" icon="times-circle" v-else/>
                    </td>
                    <td>
                        <router-link :to='`gerenciador/edit/${user.id}`'>
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
            users: []
        }
    },
    methods: {
        mounteUsers() {
            let groupId = this.$session.get('user').group.id
            this.title = this.$session.get('user').group.name
            getter.getUsersByGroupId(groupId).then(res => this.users = res)
        }
    },
    mounted() {
        this.mounteUsers()
    },
}
</script>

<style scoped>

</style>
