<template>
    <div class="container">
        <h1>{{ title }}</h1>

        <div class='row mb-3'>
            <rows label="ID" class="col-md-3" v-if="isEdit()">
                <input data-vv-as="ID" type="text" class="form-control" name="type-id" v-model="type.id" disabled>
            </rows>
            <rows label="Código" class="col-md-3">
                <input data-vv-as="ID" type="text" class="form-control" name="type-id" v-model="type.code">
            </rows>
        </div>

        <row id="name" label="Nome">
            <input data-vv-as="Nome" v-validate data-vv-rules="required" type="text" class="form-control" name="type-name" v-model="type.name">
            <require-text :error="errors.has('type-name')" :text="errors.first('type-name')" :show="true" :attribute="type.name"/>
        </row>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm" :disabled="sending">
                    Cadastrar Tipo
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'documentos-eletronicos/tipo'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import model, { TypeModel, getter } from "@/model/eletronic-documents-model";
import Type from "@/entity/EletronicDocuments/Type";
export default {
    data(){
        return {
            id: this.$route.params.id,
            title: "Adicionar Tipo",
            type: new Type(),
            sending: false,
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success ? this.submit():"")
        },
        submit() {
            this.sending = true
            if(this.isEdit()){
                TypeModel.doUpdateType(this.type).then(() => {
                    this.$router.push({ name: 'documentos-eletronicos/tipo'})
                }).catch(err => {
                    this.sending = false
                })
            } else {
                TypeModel.doInsertType(this.type).then(() => {
                    this.$router.push({ name: 'documentos-eletronicos/tipo'})
                }).catch(err => {
                    this.sending = false
                })
            }
        },
        loadValues() {
            if(this.isEdit()) { 
                getter.getTypeById(this.id).then(res => {
                    this.type = new Type(res)
                })
            }
        },
        isEdit() {
            return model.isEdit(this.id)
        }
    },
    mounted() {
        this.loadValues()
    }
}
</script>

<style lang="scss" scoped>
    #buttons {
        margin-top: 5%;
    }
</style>
