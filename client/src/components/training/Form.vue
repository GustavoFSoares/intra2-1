<template>
    <div class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <row :label="subtitles.name">
            <row>
                <v-select :data-vv-as="subtitles.name" v-validate data-vv-rules="" label="name" :options="(values.trainingsType)" name="Training-name" v-model="training.name"/>
                <require-text :error="errors.has('Training-name')" :text="errors.first('Training-name')" :show="true" :attribute="training.name"/>
            </row>
            
            <row class="container" :label="subtitles.anotherTrain" v-if="showAnotherName">
                <input :data-vv-as="subtitles.anotherTrain" v-validate data-vv-rules="required" type="text" class="form-control" name="Training-anotherName" v-model="training.anotherName">
                <require-text :error="errors.has('Training-anotherName')" :text="errors.first('Training-anotherName')" :show="true" :attribute="training.anotherName"/>
            </row>
        </row>

        <div class="row">
            <rows :label="subtitles.type">
                <v-select :data-vv-as="subtitles.type" v-validate data-vv-rules="required" label="name" :options="(values.type)" name="Training-type" v-model="training.type"/>
                <require-text :error="errors.has('Training-type')" :text="errors.first('Training-type')" :show="true" :attribute="training.instructor"/>
            </rows>

            <rows>
                <div v-if="showInstitutionalTypes">
                    <label>{{ subtitles.institutional }}</label>
                    <v-select :data-vv-as="subtitles.institutional" v-validate data-vv-rules="required" label="name" :options="(values.institutionalTypes)" name="Training-institutional-type" v-model="training.institutionalType"/>
                    <require-text :error="errors.has('Training-institutional-type')" :text="errors.first('Training-institutional-type')" :show="true" :attribute="training.institutionalTypes"/>
                </div>
            </rows>
        </div>
        
        <row :label="subtitles.instructor" class="line">
            <v-select :data-vv-as="subtitles.institutional" v-validate data-vv-rules="required" label="name" :options="(users)" name="Training-instructor" v-model="training.instructor"/>
            <require-text :error="errors.has('Training-instructor')" :text="errors.first('Training-instructor')" :show="true" :attribute="training.instructor"/>
        </row>

        <div class="row">
            <rows :label="subtitles.date">
                <label class="float-right"><b>+ Dias 
                    </b><input type="checkbox" v-model="multipleTime">
                </label>
                <date-picker id="begin-time" :multiple="multipleTime">
                    <input v-mask="'##/##/#### - ##:##'" type="text" class="form-control" id="begin-time"/>
                </date-picker>
            </rows>

            <rows :label="subtitles.workload" class="col-md-2">
                <input :data-vv-as="subtitles.workload" v-validate data-vv-rules="required|numeric" type="number" class="form-control" name="Training-workload" v-model="training.workload">
                <require-text :error="errors.has('Training-workload')" :text="errors.first('Training-workload')" :show="true" :attribute="training.workload"/>
            </rows>

            <rows :label="subtitles.place">
                <v-select :data-vv-as="subtitles.place" v-validate data-vv-rules="required" label="enterprise" :options="(values.places)" name="Training-place" v-model="training.place"/>
                <require-text :error="errors.has('Training-place')" :text="errors.first('Training-place')" :show="true" :attribute="training.place"/>
            </rows>
        </div>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                    Cadastrar Treinamento
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'hht'}" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form";
import DatePicker from "@/components/shared/Form/DatePicker.vue";
import model, { getter } from "@/model/training-model";
import Training from "@/entity/training";

export default {
    data(){
        return {
            id: '',
            title: "Cadastro de Treinamento",
            users: [],
            training: new Training(),
            subtitles: {
                name: "Nome Treinamento",
                anotherTrain: "Outro Treinamento",
                type: "Tipo",
                institutional: "Institucionais",
                instructor: "Multiplicador",
                date: "Horário do Treinamento",
                workload: "Carga Horária",
                place: "Local"
            },
            values: {
                type: [ {id: "institutional", name: "Institucional"}, {id: "extern", name: "Treinamento Externo"}, ],
                institutionalTypes: [ {id: "quality", name: "Qualidade"}, {id: "humanity", name: "Humanização"}, {id: "economy", name: "Econômico Financeiro"}, ],
                places: [],
                trainingsType: []
            },
            multipleTime: false,
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success ? this.submit():"")
        },
        submit() {
            this.training.timeTraining = document.getElementById('begin-time').value
            
            let name = ''
            if (this.training.name.name == "Outros") {
                name = this.training.anotherName
            } else {
                name = this.training.name.name ? this.training.name.name : this.training.name
            }
            this.training.name = name
            
            if(this.isEdit(this.id)){
                model.doUpdate(this.id, this.training).then(res => this.$router.go('-1'))
            } else {
                model.doInsert(this.training).then(res => this.$router.go('-1'))
            }
        },
        loadValues() {
            getter.getEnterprises().then(res => this.values.places = res)
            getter.getUsers().then(res => this.users = res)
            getter.getTrainingsType().then(res => this.values.trainingsType = res)

            this.id = this.$route.params.id
            if(this.isEdit()) {
                getter.getTrainingById(this.id).then(res => {
                    this.training = new Training(res)
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
    computed: {
        showInstitutionalTypes: function () {
            if(this.training.type) {
                return this.training.type.id == "institutional" || this.training.type == "Institucional"  ? true : false
            }
            return false
        },
        showAnotherName: function() {
            if(this.training.name) {
                return this.training.name.id == 10 ? true : false
            }
            return false
        },
    }
}
</script>

<style scoped>
    #buttons {
        margin-top: 5%;
    }

    .line {
        margin-top: 15px;
    }

    .row {
        margin-top: 15px;
    }
</style>
