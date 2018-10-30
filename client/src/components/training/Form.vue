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
            <div id="users-filter" @keyup.enter="loadUsers()">
                <div class="search-area container-fluid">
                    <div class='row'>
                        <input id="filter-input" class="form-control col-10" placeholder="Nome ou Matrícula" type="search" v-model="userFilter">
                        <button id="filter-button" class="btn btn-outline-primary" @click="loadUsers()">
                            Buscar
                        </button>
                        <icon v-if="loading" id="icon" icon="circle-notch" spin/> 
                    </div>
                </div>
                
                <div id="users-loaded" v-if="users">
                    <v-select :data-vv-as="subtitles.institutional" v-validate data-vv-rules="required" label="name" :options="(users)" name="Training-instructor" v-model="training.instructor"/>
                    <require-text :error="errors.has('Training-instructor')" :text="errors.first('Training-instructor')" :show="true" :attribute="training.instructor"/>
                </div>
            </div>
        </row>

        <div class="row">
            <rows :label="subtitles.workload" class="col-md-3">
                <clock-picker :value="training.workload" @close="getTime"/>
            </rows>

            <rows :label="subtitles.place">
                <v-select :data-vv-as="subtitles.place" v-validate data-vv-rules="required" label="enterprise" :options="(values.places)" name="Training-place" v-model="training.place"/>
                <require-text :error="errors.has('Training-place')" :text="errors.first('Training-place')" :show="true" :attribute="training.place"/>
            </rows>
        </div>

        <div class="row">
            <rows :label="subtitles.date.begin">
                <label class="float-right"><b>+ Dias 
                    </b><input type="checkbox" v-model="multipleTime">
                </label>
                <date-picker id="begin-time">
                    <input v-mask="'##/##/#### - ##:##'" type="text" class="form-control" id="begin-time"/>
                </date-picker>
            </rows>

            <rows>
                <div v-if="multipleTime">
                    <label>{{ subtitles.date.end }}</label>
                    <date-picker id="end-time" v-if="multipleTime">
                        <input v-mask="'##/##/#### - ##:##'" type="text" value="11/11/1111 - 22:22" class="form-control" id="end-time"/>
                    </date-picker>
                </div>
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
import { FormRw, FormRws, Require, VueSelect, ClockPicker } from "@/components/shared/Form";
import DatePicker from "@/components/shared/Form/DatePicker.vue";
import model, { getter } from "@/model/training-model";
const ModelGroupGetter = require("@/model/group-model").getter
const ModelUserGetter = require("@/model/user-model").getter
import Training from "@/entity/training";

export default {
    data(){
        return {
            id: '',
            title: "Cadastro de Treinamento",
            users: '',
            loading: '',
            userFilter: '',
            training: new Training(),
            subtitles: {
                name: "Nome Treinamento",
                anotherTrain: "Outro Treinamento",
                type: "Tipo",
                institutional: "Institucionais",
                instructor: "Multiplicador",
                date: {
                    begin: "Inicio do Treinamento",
                    end: "Final do Treinamento"
                },
                workload: "Carga Horária",
                place: "Local"
            },
            values: {
                type: [ {id: "institutional", name: "Institucional"}, {id: "extern", name: "Treinamento Externo"}, ],
                institutionalTypes: [ {id: "quality", name: "Qualidade e Segurança"}, {id: "humanity", name: "Humanização"}, {id: "economy", name: "Econômico Financeiro"}, ],
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
            this.training.beginTime = document.getElementById('begin-time').value
            this.training.endTime = document.getElementById('end-time')
            this.training.endTime = this.training.endTime ? this.training.endTime.value : null
            
            let name = ''
            if (this.training.name.name == "Outros") {
                name = this.training.anotherName
                delete this.training.anotherName;
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
            ModelGroupGetter.getEnterprises().then(res => this.values.places = res)
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
        getTime(value) {
            this.training.workload = value
        },
        loadUsers() {
            if(this.userFilter) {
                this.loading = true
                ModelUserGetter.getUsersByNameOrCode(this.userFilter).then(res => { 
                    this.userFilter = ''
                    this.users = res
                    this.training.instructor = ''
                    this.loading = false
                }, err => {
                    console.log(err);
                    this.userFilter = 'Erro ao realizar busca'
                    this.loading = false
                })
            }
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
        'v-select': VueSelect,
        'date-picker': DatePicker,
        'clock-picker': ClockPicker,
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

    #users-loaded {
        margin-top: 20px;
    }

    #users-filter {
        margin-left: 2%;
        margin-right: 2%;
    }
    
    #users-filter .search-area {
        margin-left: 3%;
        margin-right: 3%;
    }

    #users-filter #filter-button {
        margin-left: 20px;
        float: left
    }
    
    #users-filter #icon {
        font-size: 30px;
        margin-top: 4px;
        margin-left: 10px;
        /* float:left; */
    }

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
