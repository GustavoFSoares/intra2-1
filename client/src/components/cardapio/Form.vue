<template>
    <div class="container">
        <h1>Cadastro de Refeições</h1>
        <hr>

        <div class="row">
            
            <rows class="col-sm">
                <h5>Data da Refeição</h5>
                <uiv-date-picker id="date" v-model="cardapio.data"/>
            </rows>

            <rows class="col-sm">
                <h5>Almoço ou jantar?</h5>
                <div class="row">
                    <row class="col-sm">
                        <input type="radio" id="rbAlmoco" v-model="cardapio.refeicao" value="ALMOÇO"><label for="rbAlmoco">Almoço</label>
                    </row>
                    <row class="col-sm">
                        <input type="radio" id="rbJantar" v-model="cardapio.refeicao" value="JANTAR"><label for="rbJantar">Jantar</label>
                    </row>
                </div>
            </rows>

        </div>
        
        <div>
            <h5>Itens:</h5>
            
            <ul>
                <li v-for="(item, index) in itens">
                    <input type="text" v-model="item.one">
                    <button class="button btn" @click="deleteItem(index)"><icon icon="minus"/></button>
                </li>
            </ul>
            <button class="button btn" @click="addItem">
                <icon icon="plus"/>
            </button>
        </div>

        <div>
            <button class="btn btn-outline-primary btn-lg" id="submit-button" type="button" :disabled="sending" @click="isValidForm">
                Cadastrar
            </button>
        </div>
    </div>
</template>

<script>
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form";
import model, { getter } from "@/model/cardapio-model";
import Cardapio from "@/entity/cardapio";

export default {
    data() {
        return {
            id: this.$route.params.id,
            itens: [],
            cardapio: new Cardapio(),
            sending: false,
        }
    },
    methods: {
        addItem() {
            this.itens.push({
                one: ''
            })
        },
        deleteItem(index) {
            this.itens.splice(index, 1)
        },
        isValidForm() {
            this.$validator.validateAll().then(success => success ? this.submit():"")
        },
        submit() {
            this.setListaItens()
            let cardapio = model.mount(this.cardapio)
            this.sending = true

            if(this.isEdit()) {
                model.doUpdate(this.id, cardapio).then(res => {
                    this.$alert.success("Cardapio Atualizado")
                    this.$router.go("-1")
                    this.sending = false
                }, err => {
                    this.$alert.danger("Erro ao Atualizar")
                    this.cardapio.cardapio = undefined
                    this.sending = false
                })
            } else {
                model.doInsert(cardapio).then(res => {
                    this.$alert.success("Cardapio Inserido")
                    this.$router.go(-1)
                    this.sending = false
                }, err => {
                    this.$alert.danger("Erro ao Inserir")
                    this.cardapio.cardapio = undefined
                    this.sending = false
                })
            }
        },
        isEdit() {
            if(this.id) {
                return true
            }
            return false
        },
        setListaItens() {
            let i = 0
            this.cardapio.cardapio = this.itens[i].one
            for(i = 1;i<this.itens.length;i++){
                this.cardapio.cardapio = this.cardapio.cardapio + "\n" + this.itens[i].one
            }
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
    }
}
</script>

<style lang="scss" scoped>
.button {
    color: DodgerBlue;
}
ul{
    list-style: none;
}
</style>