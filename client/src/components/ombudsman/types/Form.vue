<template>
    <div class="container">
        <h1>{{ title }}</h1>

        <div class='row mb-3' v-if="isEdit()">
            <rows label="ID" class="col-md-3">
                <input data-vv-as="ID" type="text" class="form-control" name="type-id" v-model="type.id" disabled>
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
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'ouvidoria/tipos'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import model, { TypeModel, getter } from "@/model/ombudsman-model";
import { FormRw, FormRws, Require } from "@/components/shared/Form";

export default {
    data(){
        return {
            id: this.$route.params.id,
            title: "Adicionar Tipo",
            type: {},
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
                    this.$alert.success('Tipo Editada!')
                    
                    this.$router.push({ name: 'ouvidoria/tipos'})
                }, err => {
                    this.$alert.danger('Erro ao Editar!')
                    this.sending = false
                })
            } else {
                TypeModel.doInsertType(this.type).then(() => {
                    this.$alert.success('Tipo Inserido!')

                    this.$router.push({ name: 'ouvidoria/tipos'})
                }, err => {
                    this.$alert.danger('Erro ao Inserir!')
                    this.sending = false
                })
            }
        },
        loadValues() {
            if(this.isEdit()) { 
                getter.getTypeById(this.id).then(res => {
                    this.type = res
                })
            }
        },
        isEdit() {
            return model.isEdit(this.id)
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
    },
    mounted() {
        this.loadValues()
    }
}
</script>

<style scoped>
    #buttons {
        margin-top: 5%;
    }
</style>
