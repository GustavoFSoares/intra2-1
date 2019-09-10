<template>
    <div class="container">
        <h1 class="display-4">Cadastro de Refeições</h1>
        <hr>

        <div class="row">
            
            <rows class="col-sm">
                <h5>Data da Refeição</h5>
                <uiv-date-picker :limit-from="today" id="date" v-model="cardapio.data"/>
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
                <li class="input-group mb-2" v-for="item in itens" :key="item">
                    <input class="form-control" v-model.trim="item.one" >
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
            <router-link class="btn btn-outline-secondary btn-lg" :to="{name: 'cardapio/lista'}" tag="button" :disabled="sending">
                Voltar
            </router-link>
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
            today: new Date().toLocaleDateString('en-za'),
            id: this.$route.params.id,
            itens: [],
            cardapio: new Cardapio(),
            sending: false,
            cards: [],
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
            this.sending = true
            this.filtrarCardapio()
            this.setListaItens()
            let cardapio = model.mount(this.cardapio)

            if(this.id) {
                model.doUpdate(this.cardapio).then(res => {
                    this.$alert.success("Cardapio Atualizado")
                    this.$router.go("-1")
                    this.sending = false
                }, err => {
                    this.$alert.danger("Erro ao Atualizar: " + err)
                    this.cardapio.cardapio = undefined
                    this.sending = false
                })
            } else {
                model.doInsert(cardapio).then(res => {
                    this.$alert.success("Cardapio Inserido")
                    this.$router.go("-1")
                    this.sending = false
                }, err => {
                    this.$alert.danger("Erro ao Inserir: " + err)
                    this.cardapio.cardapio = undefined
                    this.sending = false
                })
            }
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
        },
        getCardapios() {
            getter.getCardapios().then(res => {
                this.cards = res
            })
        },
        filtrarCardapio() {

            //verifica se foi selecionada uma data
            if(this.cardapio.data == "") {
                this.$alert.danger("Escolha uma data!")
                this.sending = false
                throw new Error("Escolha uma data!")
            }

            //verifica se foi adicionado ao menos um item
            if(this.itens.length == 0) {
                this.$alert.danger("Adicione ao menos <b>1</b> item ao cardápio!")
                this.sending = false
                throw new Error("Adicione ao menos <b>1</b> item ao cardápio!")
            }

            //verifica conteudo da lista
            let a
            for(a = 0; a < this.itens.length; a++) {
                //se vazio
                if( this.itens[a].one == "") {
                    this.$alert.danger("Item vazio.")
                    this.sending = false
                    throw new Error("Item vazio")
                //senao se possui '&'
                } else if ( this.itens[a].one.search("&") != -1 ) {
                    this.$alert.danger("Por favor não utilize o caractere <b>&</b>")
                    this.sending = false
                    throw new Error("Por favor não utilize o caractere <b>&</b>")
                }
            }

            //compara cardapio com cardapios no banco
            let i
            for( i = 0; i < this.cards.length; i++) {

                let d = new Date(this.cards[i].data.date)
                d = d.toLocaleDateString('en-za').replace(/\//g, "-")

                if (d == this.cardapio.data) {
                    //se o dia for igual, compara a refeicao
                    if (this.cards[i].refeicao == this.cardapio.refeicao) {
                        //se a refeicao for igual, bloqueia
                        this.$alert.danger("Refeição já cadastrada!")
                        this.sending = false
                        throw new Error("Refeição já cadastrada!")
                    }
                }
            }

        },
    },
    mounted() {
        this.loadValues()
        this.getCardapios()
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