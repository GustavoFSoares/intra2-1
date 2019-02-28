<template>
    <div class="container">
        <h1>{{ title }}</h1>

        <div class='row mb-3'>
            <rows label="ID" class="col-md-3" v-if="isEdit()">
                <input data-vv-as="ID" type="text" class="form-control" name="status-id" v-model="status.id" disabled>
            </rows>
            <rows label="Level" class="col-md-3">
                <input data-vv-as="ID" type="text" class="form-control" name="status-id" v-model="status.level">
            </rows>
        </div>

        <row id="name" label="Nome">
            <input data-vv-as="Nome" v-validate data-vv-rules="required" type="text" class="form-control" name="status-name" v-model="status.name">
            <require-text :error="errors.has('status-name')" :text="errors.first('status-name')" :show="true" :attribute="status.name"/>
        </row>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm" :disabled="sending">
                    Cadastrar Status
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'documentos-eletronicos/status'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import model, { StatusModel, getter } from "@/model/eletronic-documents-model";
import Status from "@/entity/EletronicDocuments/Status";
export default {
    data(){
        return {
            id: this.$route.params.id,
            title: "Adicionar Status",
            status: new Status(),
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
                StatusModel.doUpdateStatus(this.status).then(() => {
                    this.$router.push({ name: 'documentos-eletronicos/status'})
                }).catch(err => {
                    this.sending = false
                })
            } else {
                StatusModel.doInsertStatus(this.status).then(() => {
                    this.$router.push({ name: 'documentos-eletronicos/status'})
                }).catch(err => {
                    this.sending = false
                })
            }
        },
        loadValues() {
            if(this.isEdit()) { 
                getter.getStatusById(this.id).then(res => {
                    this.status = new Status(res)
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
