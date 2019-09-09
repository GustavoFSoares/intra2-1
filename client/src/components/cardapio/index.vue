<template>
    <div class="container-fluid">
        <h1>Cardápio Online</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'cardapio/lista'}" tag="button" v-if="gotPermission">
            Gerenciar
        </router-link>

        <hr>

        <div>
            <h2>{{ dia }}</h2>
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
            dia: new Date().toLocaleDateString("pt-BR"),
            menu: [],
            almoco: '',
            jantar: '',
            permission: ['bruno.souza', 'testeintra'],//controla quem pode visualizar botão de cadastrar
            user: $session.get('user'),
        }
    },
    mounted() {
        getter.getCardapioMenu().then( res => {this.menu = res})
    },
    computed: {
        /**
         * Controla visualização do botao de cadastro.
         * Se usuario esta logado
         * compara id do user com lista de permissões 
         **/
        gotPermission() {
            if (this.user){
                for (var i=0; i<this.permission.length;i++) {
                    if (this.user.id == this.permission[i]) {
                        return true;
                    }
                }
                return false;
            }
            return false;
        }
    }
}
</script>