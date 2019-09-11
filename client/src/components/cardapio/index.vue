<template>
    <div class="container-fluid">
        <h1>Cardápio Online</h1>

        <router-link class="button btn btn-outline-primary btn-lg" :to="{name: 'cardapio/lista'}" tag="button" v-if="gotPermission">
            Gerenciar
        </router-link>

        <hr>

        <div>
            <h2>{{ dia }}</h2>
        </div>

        <div class="row">
            <div class="col-sm">
                <h1>Almoço</h1>
                <hr>
                <p v-for="i in almoco">{{ i }}</p>
            </div>
            <div class="col-sm">
                <h1>Jantar</h1>
                <hr>
                <p v-for="i in jantar">{{ i }}</p>
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
            almoco: '',
            jantar: '',
            permission: ['bruno.souza', 'testeintra', 'barbara.kehl', 'tatiana.nantal', 'ana.hirtz'],//controla quem pode visualizar botão de cadastrar
            user: $session.get('user'),
        }
    },
    methods: {

    },
    mounted() {
        getter.getCardapioMenu().then( res => {
            let i            
            for(i=0;i<res.length;i++) {
                switch (res[i].refeicao) {
                    case "JANTAR":
                        this.jantar = res[i].cardapio.split('&')
                        break;
                    default:
                        this.almoco = res[i].cardapio.split('&')
                        break;
                }
            }
        })
        
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

<style lang="scss" scoped>
p {
    font-size: 1.5rem;
}
</style>