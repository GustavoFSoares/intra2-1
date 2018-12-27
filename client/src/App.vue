<template>
    <div id="app">
        <nav-bar/>
            
        <div class="container-fluid">
            <div class="row">
                <rows>
                    <top-alert v-if="alert.warning" :title="alert.warning.title" :description="alert.warning.description" type="warning"/>
                </rows>

                <rows>
                    <top-alert v-if="alert.danger" :title="alert.danger.title" :description="alert.danger.description" type="danger"/>
                </rows>
            </div>
        </div>

        <div>
            <router-link to="/">
                <img id="logo" class="rounded mx-auto" src="@/../static/img/logo-gamp.jpg">
            </router-link>
        </div>

        <router-view/>
        <footer-app/>
    </div>
</template>

<script>
import AlertGetters from '@/services/alerts/getters.js'
import NavBar from '@/components/NavBar.vue'
import Footer from '@/components/Footer.vue'
import { FormRws, TopAlert } from "@/components/shared/Form/index.js"
import Vue from 'vue'

export default {
    name: 'App',
    data() {
        return {
            alert: {
                warning: '',
                danger: '',
            }
        }
    },
    components: {
        'nav-bar': NavBar,
        'footer-app': Footer,
        'rows': FormRws,
        'top-alert': TopAlert,
    },
    methods: {
        getWarningAlert() {
            AlertGetters.getWarning().then(res => this.alert.warning = res)
        },
        getDangerAlert() {
            AlertGetters.getDanger().then(res => this.alert.danger = res)
        },
        autoload() {
            window.$session = this.$session
        },
        mountPrototype() {
            var context = this
            Vue.prototype.$alert = {
                success: function(content = 'conteudo', title = ' Sucesso!' ) {
                    context.$uiv_notify({
                        type: 'success',
                        title:  title,
                        content: content,
                        customClass: 'show',
                        html: true,
                    })
                },
                danger: function(content = 'conteudo', title = ' Erro!' ) {
                    context.$uiv_notify({
                        type: 'danger',
                        title: title,
                        content: content,
                        customClass: 'show',
                        html: true,
                    })
                },
                warning: function(content = 'conteudo', title = ' Aviso!' ) {
                    context.$uiv_notify({
                        type: 'warning',
                        title: title,
                        content: content,
                        customClass: 'show',
                        html: true,
                    })
                },
                info: function(content = 'conteudo', title = ' Informação!' ) {
                    context.$uiv_notify({
                        type: 'info',
                        title: title,
                        content: content,
                        customClass: 'show',
                        html: true,
                    })
                },
                
            }
            window.$alert = this.$alert
        }
            
    },
    mounted() {
        this.getWarningAlert()
        this.getDangerAlert()
    },
    created() {
        this.mountPrototype()
        this.autoload()
    }

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
        margin-top: 10px;
    }

    .text-default {
        color: #2c3e50;
    }

    .text-disabled {
        color: rgba(105, 105, 105, 0.548);
        font-weight: bold;
    }

    div {
        /* outline: 1px dotted gray; */
    }
</style>
