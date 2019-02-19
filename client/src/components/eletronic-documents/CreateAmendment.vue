<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <div class='row'>
            <rows>

                <section>
                    <text-exibitor :document="document"/>
                </section>

            </rows>
            
            <rows>
            
                <box class="border-secondary">
                    <h3 class="text-left">Criar Emenda:</h3>
                    
                    <box>
                        
                        <row label='Titulo'>
                            <input class="form-control" v-model="amendment.title" name="Amendment-Subject" data-vv-as="Titulo" v-validate data-vv-rules="required" type="text">
                            <require-text :error="errors.has('Amendment-Subject')" :text="errors.first('Amendment-Subject')"/>
                        </row>

                        <text-editor class="text-editor" v-model="amendment.text" ref="txt"/>
                    </box>

                    <box>
                        <row label='Usuário Responsável'>
                            <v-select v-model="amendment.signatureUsers" :multiple="true" label="name" :options="usersForSignature"/>
                        </row>
                    </box>
                </box>

            </rows>
        </div>

        <section id="buttons">
            <row>
                <router-link class="btn btn-outline-primary btn-lg" :to="`/usuario/documentos-eletronicos/detalhe/${id}`" tag="button" :disabled="sending">
                    Voltar
                </router-link>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="submit()" :disabled="sending">
                    Salvar Emendas <icon v-if="sending" icon="spinner" spin/>
                </button>
            </row>
        </section>
    </div>    
</template>

<script>
import TextEditor from '@/components/shared/TextEditor.vue'
import Alert from "@/components/shared/Alert";
import TextExibitor from "./complements/TextExibitor";

import EletronicDocument from "@/entity/EletronicDocuments";
import EletronicDocumentAmendment from "@/entity/EletronicDocuments/Amendment";
import model, { getter } from "@/model/eletronic-documents-model"
export default {
    data() {
        return {
            title: "Emendas",
            id: this.$route.params.id,
            document: new EletronicDocument(),
            usersForSignature: [],
            amendment: new EletronicDocumentAmendment(),
            sending: false
        }
    },
    methods: {
        loadValues() {
            if(this.id) {
                getter.getEletronicDocumentById(this.id).then( res => { 
                    this.document = new EletronicDocument(res);
                })
                getter.getUsersSigned(this.id).then(res => {
                    this.usersForSignature = res
                })
            }
        },
        addAmendment() {
            this.document.amendmentList.push( this.amendment )
            this.amendment = new EletronicDocumentAmendment()
        },
        submit() {
            this.$validator.validateAll().then(success => {
                if(success) {

                    Alert.YesNo('Cadastrando Emenda', 'Tem certeza que deseja salvar?').then( res => {
                        if(res) {
                            this.sending = true
                            
                            this.addAmendment()
                            model.updateAmendment(this.document).then(res => {
                                this.$router.push({ name: 'documentos-eletronicos' })
                                this.sending = false
                            }).catch(err => {
                                this.sending = false
                                setTimeout(() => {
                                    this.$route.go()
                                }, 2000);
                            })
                        }
                    })

                }
            })
        }
    },
    components: {
        'text-editor': TextEditor,
        'text-exibitor': TextExibitor,
    },
    mounted() {
        this.loadValues()
    }
}
</script>

<style scoped>
    .text-editor {
        margin: auto;
    }
</style>
