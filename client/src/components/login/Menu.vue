<template>
    <div class="nav-item">
        <ul class="navbar-nav mr-auto">
            <router-link @click.native="$router.push(`/usuario/gerenciador/edit/${user.id}`)" v-if="sessionExists && !user.email" to="" class="nav-link">
                <icon v-tooltip.top="'Clique para Cadastrar seu Email!'" class="text-warning" icon="exclamation-triangle"/>
            </router-link>
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
    props: {
        value: { default: 0}
    },
    watch: {
        value() {
            this.forceUpdate()
        }
    },
    methods: {
        login() {
            this.$router.push('/login')
        },
        logout() {
            model.doLogout()
        },
        forceUpdate() {
            this.user = this.$session.get('user')
            this.exibition.name = this.user.name
        }
    },
    mounted() {
        if(this.$session.exists()) {
            this.exibition.name = this.$session.get('user').name
            this.exibition.path = '/usuario'
        }
    },
}
</script>