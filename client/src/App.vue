<template>
    <div id="app">
        <nav-bar/>
            
        <div class="row">
            <rows>
                <top-alert :title="alert.warning.title" :description="alert.warning.description" type="warning"/>
            </rows>

            <rows>
                <top-alert :title="alert.danger.title" :description="alert.danger.description" type="danger"/>
            </rows>
        </div>

        <div>
            <router-link to="/">
                <img id="logo" class="rounded mx-auto d-block" src="@/../static/img/logo-gamp.jpg">
            </router-link>
        </div>

        <router-view/>
        <footer-app/>
    </div>
</template>

<script>
import NavBar from '@/components/NavBar.vue'
import Footer from '@/components/Footer.vue'
import { FormRws, TopAlert } from "@/components/shared/Form/index.js"

export default {
    name: 'App',
    data() {
        return {
            alert: {
                warning: {
                    title: "Um titulo bem grande aqui mew, é serio mesmo",
                    description: "Intranet irá sair fora do ar e retornar para 7 horas da noite aproxi madamente papibaqu igrafo laringologista testeIntranet irá sair fora do ar e retornar para 7 horas da noite aproxi madamente papibaqu igrafo laringologista testeIntranet irá sair fora do ar e retornar para 7 horas da noite aproxi madamente papibaqu igrafo laringologista teste",
                },
                danger: {
                    title: "Um titulo bem grande aqui mew, é serio mesmo",
                    description: "Intranet irá sair fora do ar e retornar para 7 horas da noite aproxi madamente papibaqu igrafo laringologista testeIntranet irá sair fora do ar e retornar para 7 horas da noite aproxi madamente papibaqu igrafo laringologista teste",
                }
            }
        }
    },
    components: {
        'nav-bar': NavBar,
        'footer-app': Footer,
        'rows': FormRws,
        'top-alert': TopAlert,
    },

}
</script>

<style>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-bottom: 100px;
    }

    #logo {
        width: 20%;
        margin-top: -30px;
    }
</style>
