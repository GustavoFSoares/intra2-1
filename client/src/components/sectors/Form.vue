<template>
    <div class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <div class="row">
            <rows :label="subtitles.name">
                <input :data-vv-as="subtitles.name" v-validate data-vv-rules="required" type="text" class="form-control" name="Sector-name" v-model="sector.name">
                <require-text :error="errors.has('Sector-title')" :text="errors.first('Sector-title')" :attribute="sector.name"/>
            </rows>
            
            <rows>
                <div class='row enterprise'>
                    <rows :label="subtitles.enterprise">
                        <input :data-vv-as="subtitles.enterprise" v-validate data-vv-rules="required" type="text" class="form-control" name="Sector-enterprise" v-model="sector.enterprise">
                    </rows>
                </div>
                <require-text :error="errors.has('sector-enterprise')" :text="errors.first('Sector-enterprise')" :show="true" :attribute="sector.enterprise"/>
            </rows>
        </div>

        <div class="mt-3">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm" :disabled="sending">
                    Salvar <icon icon="spinner" spin v-if="sending"/>
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'sector'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import { Checkbox } from "@/components/shared/Form";

import model, { getter } from "@/model/sector-model";
import Sector from "@/entity/Sector";

export default {
    data(){
        return {
            id: '',
            title: "Cadastro de Setor",
            sector: new Sector(),
            subtitles: {
                name: "Nome",
                enterprise: "Empresa"
            },
            sending: false,
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success ? this.submit():"")
        },
        submit() {
            this.sending = true
            if(this.isEdit(this.id)){
                model.doUpdate(this.id, this.sector).then(res => {
                    this.$router.push( {name: 'sector'} )
                }).catch(err => {
                    console.log("Erro ao atualizar: "+err)
                    this.sending = false
                })
            } else {
                model.doInsert(this.sector).then(res => { 
                    this.$router.push( {name: 'sector'} )
                }).catch(err => {
                    this.sending = false
                })
            }
        },
        loadValues() {
            this.id = this.$route.params.id
            if(this.isEdit()) {
                this.title = "Edição de Setor"
                getter.getSectorById(this.id).then(res => {
                    this.sector = new Sector(res)
                })
            }
        },
        isEdit() {
            return model.isEdit(this.id)
        },
    },
    components: {
        'checkbox': Checkbox,
    },
    mounted() {
        this.loadValues()
    },
}
</script>

<style lang="scss" scoped>
    .enterprise {
        display: flex;
        align-items: center;

        .demonstration {
            text-align: left;
        }
    }
</style>
