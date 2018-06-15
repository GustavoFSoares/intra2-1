<template>
    <div class="nav-item">
        <ul class="navbar-nav mr-auto">
            <router-link :to="exibition.path" class="nav-link">
                    {{ exibition.name }}
                    <i class="fa fa-user" style="font-size:20px"></i>
            </router-link>
            
            <router-link @click.native="logout" v-if="sessionExists" to="" class="nav-link">
                    <i class="fa fa-power-off" style="font-size:20px"></i>
            </router-link>
        </ul>
    </div>  
</template>

<script>
import User from "@/entity/User";
import model from "@/model/login-model";

export default {
    data() {
        return {
            user: new User(this.$session.get('user')),
            exibition: {
                name: 'Login',
                path: '/login',
            },
            sessionExists: this.$session.exists()
        }
    },
    methods: {
        login() {
            this.$router.push('/login')
        },
        logout() {
            model.doLogout()
        },
    },
    mounted() {
        if(this.$session.exists()) {
            this.exibition.name = this.$session.get('user').name
            this.exibition.path = '/usuario'
        }
    },
}
</script>

<style scoped>

</style>
