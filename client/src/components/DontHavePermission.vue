<template>
    <div class="container">
        <h1>{{ title }}</h1>
        <div class="card">
            <div class="card-header">
                {{ content.subtitle }}
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    {{ content.title }} <i><u>{{access.path}}</u></i>
                </h5>
                <p class="card-text">{{ content.text }}</p>
                <div id="permissions">
                    <ul>
                        <li v-for="(message, index) of messages" :key="index" v-if="access.permissions[index] === false">Permissão <b>{{message}}</b> necessária</li>
                    </ul>
                </div>   
                <p class="card-text">{{ content.footer }}</p>
            </div>
        </div>
        <BR/>
        <router-link class="btn btn-outline-primary" to="/">Voltar ao início</router-link>
    </div>
</template>

<script>
console.log(window.access);

export default {
    created() {
        if(!window.access){
            this.$router.push('/')
        }
    },
    data() {
        return {
            title: "Acesso Restringido",
            content: {
                title: "Ao acessar",
                subtitle: "Você não tem permissão para ver essa página",
                text: "Para prosseguir você precisa de todas as seguintes permissões:",
                footer: "Por favor, contate a TI no 8081"
            },
            messages: {
                group: '"Grupo"',
                admin: '"Administrador"',
                level: '"Nível"',
            },
            access: window.access,
        }
    },
}
</script>

<style scoped>
    li {
        text-align: left;
    }
</style>
