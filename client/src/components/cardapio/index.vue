<template>
    <div class="container-fluid">
        <h1>Cardápio Online</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'cardapio/'}" tag="button" v-if="gotPermission">
            Cadastrar Refeições
        </router-link>

        <div>
            <h2>{{ dia[0] }}</h2>
        </div>

        <div class="row">
            <div class="col-sm" v-for="item in menu">
                <h1>{{ item.refeicao }}</h1>
                <p>{{ item.cardapio }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import model, { getter } from "@/model/cardapio-model";

export default {
    data() {
        return {
            dia: new Date().toLocaleString("pt-BR").split(" "),
            menu: [],
            almoco: '',
            jantar: '',
            permission: 'undefined',
        }
    },
    mounted() {
        getter.getCardapioMenu().then( res => {this.menu = res})
    },
    computed: {
        gotPermission() {
            if(this.permission == 'undefined') {
                model.gotPermission().then(permission => { this.permission = permission; } )
            } else {
                return (this.permission != 'USER' && this.permission) ? true : false
            }
        }
    }
}
</script>