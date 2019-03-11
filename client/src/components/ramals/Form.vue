<template>
    <div class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <row :label="subtitles.group">
            <v-select :data-vv-as="subtitles.group" v-validate data-vv-rules="required" label="name" :options="(values.groups)" name="Ramal-group" v-model="ramal.group"/>
            <require-text :error="errors.has('Ramal-group')" :text="errors.first('Ramal-group')" :show="true" :attribute="ramal.group"/>
        </row>

        <div class="row">
            <rows :label="subtitles.ramal">
                <input :data-vv-as="subtitles.ramal" v-validate data-vv-rules="required" type="text" v-mask="'####'" class="form-control" name="Ramal-number" v-model="ramal.number">
                <require-text :error="errors.has('Ramal-number')" :text="errors.first('Ramal-number')" :show="true" :attribute="ramal.number"/>
            </rows>
            
            <rows :label="subtitles.floor">
                <v-select :data-vv-as="subtitles.floor" v-validate data-vv-rules="required" label="value" :options="(values.floor)" name="Ramal-floor" v-model="ramal.floor"/>
                <!-- <input :data-vv-as="subtitles.floor" v-validate data-vv-rules="required" type="text" class="form-control" name="Ramal-floor" v-model="ramal.floor"> -->
                <require-text :error="errors.has('Ramal-floor')" :text="errors.first('Ramal-floor')" :show="true" :attribute="ramal.floor"/>
            </rows>

            <rows :label="subtitles.core">
                <input :data-vv-as="subtitles.core" v-validate data-vv-rules="required" type="text" class="form-control" name="Ramal-core" v-model="ramal.core">
                <require-text :error="errors.has('Ramal-core')" :text="errors.first('Ramal-core')" :show="true" :attribute="ramal.core"/>
            </rows>            
        </div>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                    Cadastrar Ramal
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'ramais'}" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form";
import model, { getter } from "@/model/ramal-model";
import Ramal from "@/entity/Ramal";

export default {
    data(){
        return {
            id: '',
            title: "Cadastro de Ramais",
            ramal: new Ramal(),
            subtitles: {
                ramal: "Ramal",
                core: "Núcleo",
                group: "Grupo",
                floor: "Andar",
            },
            values: {
                groups: [],
                floor: [
                    {"value": "Subsolo"},
                    {"value": "Térreo"},
                    {"value": "2º Andar"},
                    {"value": "3º Andar"},
                    {"value": "4º Andar"},
                    {"value": "5º Andar"},
                    {"value": "6º Andar"},
                    {"value": "7º Andar"},
                    {"value": "8º Andar"},
                    {"value": "9º Andar"},
                    {"value": "10º Andar"},
                ]
            },
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success ? this.submit():"")
        },
        submit() {
            this.ramal.floor = this.ramal.floor.value ? this.ramal.floor.value : this.ramal.floor
            
            if(this.isEdit(this.id)){
                model.doUpdate(this.id, this.ramal).then(res => this.$router.go('-1'))
            } else {
                model.doInsert(this.ramal).then(res => this.$router.go('-1'))
            }
        },
        loadValues() {
            getter.getGroups().then(res => this.values.groups = res )

            this.id = this.$route.params.id
            if(this.isEdit()) {
                getter.getRamalById(this.id).then(res => {
                    this.ramal = new Ramal(res)
                })
            }
        },
        isEdit() {
            return model.isEdit(this.id)
        },
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
        'v-select': VueSelect,
    },
    mounted() {
        this.loadValues()
    },
}
</script>

<style lang="scss" scoped>
    #buttons {
        margin-top: 5%;
    }
</style>
