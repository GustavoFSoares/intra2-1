<template>
    <div class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <div class="row">
            <rows :label="subtitles.name">
                <input :data-vv-as="subtitles.name" v-validate data-vv-rules="required" type="text" class="form-control" name="RoomTraining-name" v-model="roomTraining.name">
                <require-text :error="errors.has('RoomTraining-name')" :text="errors.first('RoomTraining-name')" :show="true" :attribute="roomTraining.name"/>
            </rows>
            
            <rows :label="subtitles.floor">
                <v-select :data-vv-as="subtitles.floor" v-validate data-vv-rules="required" label="value" :options="(values.floor)" name="RoomTraining-floor" v-model="roomTraining.floor"/>
                <require-text :error="errors.has('RoomTraining-floor')" :text="errors.first('RoomTraining-floor')" :show="true" :attribute="roomTraining.floor"/>
            </rows>
        </div>

        <row :label="subtitles.group" class="mt-3">
            <v-select :data-vv-as="subtitles.group" v-validate data-vv-rules="required" label="name" :options="(values.groups)" name="RoomTraining-group" v-model="roomTraining.group"/>
            <require-text :error="errors.has('RoomTraining-group')" :text="errors.first('RoomTraining-group')" :show="true" :attribute="roomTraining.group"/>
        </row>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" :disabled="sending" @click="isValidForm">
                    Cadastrar Sala
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'sala-treinamento'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form"
import model, { getter } from "@/model/room-training-model"
const GroupModel = require("@/model/group-model").getter

export default {
    data(){
        return {
            id: this.$route.params.id,
            title: "Cadastro de Salas",
            roomTraining: {},
            sending: false,
            subtitles: {
                name: "Nome da Sala",
                group: "Setor",
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
            this.roomTraining.floor = this.roomTraining.floor.value ? this.roomTraining.floor.value : this.roomTraining.floor
            this.sending = true
            
            if(this.isEdit(this.id)){
                model.doUpdate(this.id, this.roomTraining).then(res => { 
                    this.$router.go('-1') 
                    this.sending = false
                }, err => {
                    this.$alert.danger('Erro ao Inserir')
                    this.sending = false
                })
            } else {
                model.doInsert(this.roomTraining).then(res => { 
                    this.$router.go('-1') 
                    this.sending = false
                }, err => {
                    this.$alert.danger('Erro ao Editar')
                    this.sending = false
                })
            }
        },
        loadValues() {
            GroupModel.getGroups().then(res => this.values.groups = res )

            if(this.isEdit()) {
                getter.getRoomTrainingById(this.id).then(res => {
                    this.roomTraining = res
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

<style scoped>
    #buttons {
        margin-top: 5%;
    }
</style>
