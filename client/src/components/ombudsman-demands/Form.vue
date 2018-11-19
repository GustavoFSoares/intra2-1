<template>
    <div class="container">
        <h1>{{ title }}</h1>

        <div class='row mb-3' v-if="isEdit()">
            <rows label="ID" class="col-md-3">
                <input data-vv-as="ID" type="text" class="form-control" name="demand-id" v-model="demand.id" disabled>
            </rows>
        </div>

        <row id="name" label="Nome">
            <input data-vv-as="Nome" v-validate data-vv-rules="required" type="text" class="form-control" name="demand-name" v-model="demand.name">
            <require-text :error="errors.has('demand-name')" :text="errors.first('demand-name')" :show="true" :attribute="demand.name"/>
        </row>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm" :disabled="sending">
                    Cadastrar Demanda
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'ouvidoria-demandas'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import model, { getter } from "@/model/ombudsman-model";
import { FormRw, FormRws, Require } from "@/components/shared/Form";

export default {
    data(){
        return {
            id: this.$route.params.id,
            title: "Adicionar Demanda",
            demand: {},
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
                model.doUpdateDemand(this.demand).then(() => {
                    this.$alert.success('Demanda Editada!')
                    
                    this.$router.push({ name: 'ouvidoria-demandas'})
                }, err => {
                    this.$alert.success('Erro ao Editar!')
                    this.sending = false
                })
            } else {
                model.doInsertDemand(this.demand).then(() => {
                    this.$alert.danger('Demanda Inserida!')

                    this.$router.push({ name: 'ouvidoria-demandas'})
                }, err => {
                    this.$alert.danger('Erro ao Inserir!')
                    this.sending = false
                })
            }
        },
        loadValues() {
            if(this.isEdit()) { 
                getter.getDemandById(this.id).then(res => {
                    this.demand = res
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
