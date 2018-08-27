<template>
    <div class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <row>
            <div class="row">
                <rows :label="subtitles.id" class="col-md-3">
                    <input :data-vv-as="subtitles.id" v-validate data-vv-rules="required" type="text" class="form-control" name="Collaborator-id" v-model="collaborator.id" :disabled="isEdit()">
                    <require-text :error="errors.has('Collaborator-id')" :text="errors.first('Collaborator-id')" :show="true" :attribute="collaborator.id"/>
                </rows>
                <rows :label="subtitles.name">
                    <input :data-vv-as="subtitles.name" v-validate data-vv-rules="required" type="text" class="form-control" name="Collaborator-name" v-model="collaborator.name">
                    <require-text :error="errors.has('Collaborator-name')" :text="errors.first('Collaborator-name')" :show="true" :attribute="collaborator.name"/>
                </rows>
            </div>
        </row>
        
        <div class="row mb-3">
            <rows :label="subtitles.group">
                <v-select :data-vv-as="subtitles.group" v-validate data-vv-rules="required" label="name" :options="(values.groups)" name="Collaborator-group" v-model="collaborator.group"/>
                <require-text :error="errors.has('Collaborator-group')" :text="errors.first('Collaborator-group')" :show="true" :attribute="collaborator.group"/>
            </rows>
            
            <rows :label="subtitles.occupation">
                <input :data-vv-as="subtitles.occupation" v-validate data-vv-rules="required" type="text" class="form-control" name="Collaborator-occupation" v-model="collaborator.occupation">
                <require-text :error="errors.has('Collaborator-occupation')" :text="errors.first('Collaborator-occupation')" :show="true" :attribute="collaborator.occupation"/>
            </rows>
        </div>
        
        <div class="row mb-3">
            <rows :label="subtitles.hire">
                <date-picker opens="center" id="hire" :onlycalendar="true" format="DD/MM/YYYY">
                    <input type="text" class="form-control" id="hire"/>
                </date-picker>
            </rows>
            
            <rows :label="subtitles.fire">
                <date-picker opens="center" id="fire" :onlycalendar="true" format="DD/MM/YYYY">
                    <input type="text" class="form-control" id="fire"/>
                </date-picker>
            </rows>
            
            <rows :label="subtitles.turn">
                <input :data-vv-as="subtitles.turn" v-validate data-vv-rules="required" type="text" class="form-control" name="Collaborator-turn" v-model="collaborator.complement.turn">
            </rows>
        </div>

        <div class="row mb-3">
            <rows :label="subtitles.type">
                <v-select :data-vv-as="subtitles.type" v-validate data-vv-rules="required" label="name" :options="(values.collaboratorTypes)" name="Collaborator-type" v-model="collaborator.complement.type"/>
                <require-text :error="errors.has('Collaborator-type')" :text="errors.first('Collaborator-type')" :show="true" :attribute="collaborator.complement.type"/>
            </rows>
            
            <rows :label="subtitles.entity">
                <input :data-vv-as="subtitles.entity" v-validate data-vv-rules="required" type="text" class="form-control" name="Collaborator-entity" v-model="collaborator.complement.entity">
                <require-text :error="errors.has('Collaborator-entity')" :text="errors.first('Collaborator-entity')" :show="true" :attribute="collaborator.complement.entity"/>
            </rows>
        </div>

        <row label="Removido" v-if="isEdit()">
            <input type="checkbox" v-model="collaborator.c_removed">
        </row>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                    Cadastrar Colaborador
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'colaboradores'}" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import { FormRw, FormRws, Require, VueSelect, DatePicker } from "@/components/shared/Form";
import model, { getter } from "@/model/collaborator-model";

export default {
    data(){
        return {
            id: '',
            title: "Cadastro de Universitários",
            collaborator: { complement: {} },
            subtitles: {
                id: "Matrícula",
                name: "Nome",
                occupation: "Cargo",
                group: "Grupo",
                hire: "Contratação",
                fire: "Demição",
                turn: "Turno",
                entity: "Entidade",
                type: "Tipo",
            },
            values: {
                groups: [],
                collaboratorTypes: [],
            },
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success ? this.submit():"")
        },
        submit() {
            this.collaborator.complement.hire = document.getElementById("hire").value
            this.collaborator.complement.fire = document.getElementById("fire").value
            this.collaborator.code = this.collaborator.id

            if(this.isEdit(this.id)){
                model.doUpdate(this.id, this.collaborator).then(res => this.$router.go('-1'))
            } else {
                this.collaborator.id = this.collaborator.complement.type.name.substr(0,1)+this.collaborator.id
                model.doInsert(this.collaborator).then(res => this.$router.go('-1'))
            }
        },
        loadValues() {
            getter.getGroups().then(res => this.values.groups = res )
            getter.getCollaboratorTypes().then(res => this.values.collaboratorTypes = res )

            this.id = this.$route.params.id
            if(this.isEdit()) {
                getter.getCollaboratorById(this.id).then(res => {
                    this.collaborator = res
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
        'date-picker': DatePicker,
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
