<template>
    <div class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <row>
            <div class="row">
                <rows :label="subtitles.id" class="col-md-3">
                    <input :data-vv-as="subtitles.id" v-validate data-vv-rules="required" type="text" class="form-control" name="Student-id" v-model="student.id">
                    <require-text :error="errors.has('Student-id')" :text="errors.first('Student-id')" :show="true" :attribute="student.id"/>
                </rows>
                <rows :label="subtitles.name">
                    <input :data-vv-as="subtitles.name" v-validate data-vv-rules="required" type="text" class="form-control" name="Student-name" v-model="student.name">
                    <require-text :error="errors.has('Student-name')" :text="errors.first('Student-name')" :show="true" :attribute="student.name"/>
                </rows>
            </div>
        </row>
        
        <div class="row mb-3">
            <rows :label="subtitles.group">
                <v-select :data-vv-as="subtitles.group" v-validate data-vv-rules="required" label="name" :options="(values.groups)" name="Student-group" v-model="student.group"/>
                <require-text :error="errors.has('Student-group')" :text="errors.first('Student-group')" :show="true" :attribute="student.group"/>
            </rows>
            
            <rows :label="subtitles.occupation">
                <input :data-vv-as="subtitles.occupation" v-validate data-vv-rules="required" type="text" class="form-control" name="Student-occupation" v-model="student.occupation">
                <require-text :error="errors.has('Student-occupation')" :text="errors.first('Student-occupation')" :show="true" :attribute="student.occupation"/>
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
                <input :data-vv-as="subtitles.turn" v-validate data-vv-rules="required" type="text" class="form-control" name="Student-turn" v-model="student.turn">
                <require-text :error="errors.has('Student-turn')" :text="errors.first('Student-turn')" :show="true" :attribute="student.turn"/>
            </rows>
        </div>

        <row label="Removido" v-if="isEdit()">
            <input type="checkbox" v-model="student.c_removed">
        </row>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                    Cadastrar Universitario
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'universitarios'}" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import { FormRw, FormRws, Require, VueSelect, DatePicker } from "@/components/shared/Form";
import model, { getter } from "@/model/student-model";

export default {
    data(){
        return {
            id: '',
            title: "Cadastro de Universitários",
            student: {},
            subtitles: {
                id: "Matrícula",
                name: "Nome",
                occupation: "Cargo",
                group: "Grupo",
                hire: "Contratação",
                fire: "Demição",
                turn: "Turno",
            },
            values: {
                groups: [],
            },
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success ? this.submit():"")
        },
        submit() {
            this.student.hire = document.getElementById("hire").value
            this.student.fire = document.getElementById("fire").value
            this.student.code = this.student.id

            if(this.isEdit(this.id)){
                model.doUpdate(this.id, this.student).then(res => this.$router.go('-1'))
            } else {
                model.doInsert(this.student).then(res => this.$router.go('-1'))
            }
        },
        loadValues() {
            getter.getGroups().then(res => this.values.groups = res )

            this.id = this.$route.params.id
            if(this.isEdit()) {
                getter.getStudentById(this.id).then(res => {
                    this.student = res
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
