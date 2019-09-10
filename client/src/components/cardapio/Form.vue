<template>
    <div class="container">
        <h1 class="display-4">Cadastro de Refeições</h1>
        <hr>

        <div class="row">
            
            <rows class="col-sm">
                <h5>Data da Refeição</h5>
                <uiv-date-picker id="date" v-model="cardapio.data"/>
            </rows>

            <rows class="col-sm">
                <h5>Almoço ou jantar?</h5>
                
                    <div class="radio">
                        <label class="">
                            <input type="radio" id="rbAlmoco" v-model="cardapio.refeicao" value="ALMOÇO" checked>
                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                            Almoço
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <input type="radio" id="rbJantar" v-model="cardapio.refeicao" value="JANTAR">
                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                            Jantar
                        </label>
                    </div>
                    
            </rows>

        </div>
        
        <div>
            <h5>Itens:</h5>
            
            <ul>
                <li v-for="(item, index) in itens">
                    <input v-model.trim="item.one">
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
                model.doUpdate(this.cardapio).then(res => {
                    this.$alert.success("Cardapio Atualizado")
                    this.$router.go("cardapio/lista")
                    this.sending = false
                }, err => {
                    this.$alert.danger("Erro ao Atualizar: " + err)
                    this.cardapio.cardapio = undefined
                    this.sending = false
                })
            } else {
                model.doInsert(cardapio).then(res => {
                    this.$alert.success("Cardapio Inserido")
                    this.$router.go("cardapio/lista")
                    this.sending = false
                }, err => {
                    this.$alert.danger("Erro ao Inserir: " + err)
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
                this.cardapio.cardapio = this.cardapio.cardapio + "&" + this.itens[i].one
            }
        },
        loadValues() {
            if(this.id) {
                this.sending = true
                getter.getCardapioById(this.id).then( res => {
                    this.cardapio = new Cardapio(res)
                    let itemArray = this.cardapio.cardapio.split('&')
                    let i
                    for(i = 0; i < itemArray.length ; i++) {
                        this.itens.push({one: itemArray[i]})
                    }

                    this.sending = false
                })
            }
        }
    },
    mounted() {
        this.loadValues()
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
#date {
    margin-left: 8em;
}
h5 {
    margin-bottom: 2em;
    font-size: 2rem;
}

//radio buttons 
.radio label {
    font-size: 1.5rem;
    margin-bottom: 1em;
}

.radio label:after {
    content: '';
    display: table;
    clear: both;
}

.radio .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.radio .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.radio .cr .cr-icon {
    margin-left: 0.04em;
}

.radio label input[type="radio"] {
    display: none;
}

.radio label input[type="radio"] + .cr > .cr-icon {
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.radio label input[type="radio"]:checked + .cr > .cr-icon {
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.radio label input[type="radio"]:disabled + .cr {
    opacity: .5;
}
</style>