<template>
    <div class="container">
        <h1>{{ title }}</h1>

        <row :label="subtitles.name">
            <row>
                <v-select :data-vv-as="subtitles.name" v-validate data-vv-rules="required" label="name" :options="(values.trainingsType)" name="Training-name" v-model="training.name"/>
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
        
        <row :label="subtitles.instructor" class="mt-3">
            <div id="users-filter">
                <div class="search-area container-fluid">
                    <div class='row' @keyup.enter="loadUsers()">
                        <input id="filter-input" class="form-control col-10" placeholder="Nome ou Matrícula" type="search" v-model="userFilter">
                        <button id="filter-button" class="btn btn-outline-primary" @click="loadUsers()" :disabled="loading">
                            Buscar
                        </button>
                        <icon v-if="loading" id="icon" icon="circle-notch" spin/> 
                    </div>
                </div>
                <div id="users-loaded" v-if="values.users.length">
                    <v-select :data-vv-as="subtitles.instructors" v-validate data-vv-rules="required" label="name" :options="(values.users)" name="Training-instructor" v-model="instructorSelected" @input="addInstructor()"/>
                </div>
                <require-text :error="errors.has('Training-instructor')" :text="errors.first('Training-instructor')" :show="true" :attribute="training.instructor"/>
            </div>

            <div id="instructors-list" class="mt-3" v-if="training.instructors.length">
                    {{training.instructors.lenght}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-subtitle text-muted mb-2">Palestrantes</h5>

                        <div class="">
                            <span class="instructor" v-for="(instructor, index) of training.instructors" :key="index">
                                <div class="line">
                                    <span class="pull-right">
                                        {{ instructor.name }}
                                        <router-link class="text-danger" v-if="instructor.canRemove" to="" @click.native="removeInstructor(index)">
                                            <icon class="ml-3" icon="minus"/>
                                        </router-link>
                                    </span>
                                    <br><hr>
                                </div>
                                
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </row>

        <div class="row mt-3">
            
        </div>

        <div class="row">
            <rows id="times">

                <h5>{{ subtitles.date.title }}</h5>                
                <div class="row">
                    <rows class="col-md-7">
                        <h5>{{ subtitles.date.day }}:</h5>
                        <uiv-date-picker id="day" v-model="dateTraining"/>
                    </rows>
                    
                    <rows class="com-md-3">
                        <row>
                            <h5 class="time-name">{{ subtitles.date.beginTime }}:</h5>
                            <uiv-time-picker id="time" icon-control-up="glyphicon glyphicon-plus" icon-control-down="glyphicon glyphicon-minus" :show-meridian="false" v-model="training.beginTime"/>
                        </row>
                        
                        <row>
                            <h5 class="time-name">{{ subtitles.date.endTime }}:</h5>
                            <uiv-time-picker id="time" icon-control-up="glyphicon glyphicon-plus" icon-control-down="glyphicon glyphicon-minus" :show-meridian="false" v-model="training.endTime"/>
                        </row>
                    </rows>

                </div>
            </rows>
            
            <rows label=''>

                <h5>{{ subtitles.place.title }}</h5>
                <row :label="subtitles.place.enterprise">
                    <v-select :data-vv-as="subtitles.place.enterprise" v-validate data-vv-rules="required" label="enterprise" :options="(values.places)" name="Training-place" v-model="training.place.group"/>
                    <require-text :error="errors.has('Training-place')" :text="errors.first('Training-place')" :show="true" :attribute="training.place.group"/>
                </row>
                
                <row :label="subtitles.place.room">
                    <v-select label="name" :options="(values.roomTraining)" name="Training-roomTraining" v-model="training.place.room"/>
                </row>
                
                <h5 id="place-training">
                    <span>
                        {{ training.place.group.enterprise }}
                        <span v-if="training.place.room">
                             - {{ training.place.room.name }}, {{ training.place.room.floor }}
                        </span>
                    </span>
                </h5>
                <span>Carga Horária: 
                    <b>{{ workload.hour }}</b> : <b>{{ workload.minute}}</b>
                </span>

            </rows>

        </div>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" :disabled="sending" @click="isValidForm">
                    Cadastrar Treinamento
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'hht'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form";
import model, { getter } from "@/model/training-model";
const ModelGroupGetter = require("@/model/group-model").getter
const ModelUserGetter = require("@/model/user-model").getter
const ModelRoomTreining = require("@/model/room-training-model").getter
import Training from "@/entity/training";

export default {
    data(){
        return {
            id: this.$route.params.id,
            title: "Cadastro de Treinamento",
            Texto: '>>Local onde será realizado treinamento<<',
            dateTraining: new Date(),
            loading: false,
            sending: false,
            userFilter: '',
            instructorSelected: '',
            training: new Training(),
            subtitles: {
                name: "Nome Treinamento",
                anotherTrain: "Outro Treinamento",
                type: "Tipo",
                institutional: "Institucionais",
                instructors: "Multiplicador",
                date: {
                    title: "Data Treinamento",
                    day: "Dia",
                    beginTime: "Horário Início",
                    endTime: "Horário Fim",
                },
                workload: "Carga Horária",
                place: {
                    title: "Local Treinamento",
                    enterprise: "Empresa",
                    room: "Sala",
                }
            },
            values: {
                type: [ {id: "institutional", name: "Institucional"}, {id: "extern", name: "Treinamento Externo"}, {id: "specific-technician", name: "Técnico-Específico"}, {id: "selfdevelpment", name: "Autodesenvolvimento"}, ],
                institutionalTypes: [ {id: "quality", name: "Qualidade e Segurança"}, {id: "humanity", name: "Humanização"}, {id: "economy", name: "Econômico Financeiro"}, ],
                places: [],
                trainingsType: [],
                roomTraining: [],
                users: [],
            },
            multipleTime: false,
        }
    },
    methods: {
        isValidForm() {
            this.$validator.validateAll().then(success => success ? this.submit():"")
        },      
        submit() {
            let training = model.mount(this.training, this.dateTraining)
            this.sending = true
            
            if(this.isEdit(this.id)){
                model.doUpdate(this.id, training).then(res => {
                    this.$alert.success('Treinamento Atualizado')
                    this.$router.go('-1')
                    this.sending = false
                }, err => {
                    this.$alert.danger('Erro ao Atualizado')
                    this.sending = false
                })

            } else {
                model.doInsert(training).then(res => {
                    this.$alert.success('Treinamento Inserido')
                    this.$router.go('-1')
                    this.sending = false
                }, err => {
                    this.$alert.danger('Erro ao Inserir')
                    this.sending = false
                })
            }
        },
        loadValues() {
            ModelGroupGetter.getEnterprises().then(res => this.values.places = res)
            getter.getTrainingsType().then(res => this.values.trainingsType = res)
            ModelRoomTreining.getRoomsTraining().then(res => this.values.roomTraining = res)

            if(this.isEdit()) {
                getter.getTrainingById(this.id).then(res => {
                    this.training = new Training(res)
                    this.dateTraining = this.training.beginTime
                })
            }

        },
        isEdit() {
            return model.isEdit(this.id)
        },
        getTime(value) {
            this.training.workloadvalue
        },
        loadUsers() {
            if(this.userFilter) {
                this.loading = true
                this.values.users = ''
                ModelUserGetter.getUsersByNameOrCode(this.userFilter).then(res => { 
                    this.userFilter = ''
                    this.values.users = res
                    this.loading = false
                }, err => {
                    console.log(err);
                    this.$alert.warning('Erro ao realizar busca')
                    this.loading = false
                })
            }
        },
        addInstructor() {
            if(this.instructorSelected) {
                this.instructorSelected.canRemove = true
                
                this.training.instructors.push(this.instructorSelected);
                this.instructorSelected = ''
                this.values.users = ''
            }
        }, 
        removeInstructor(instructorIndex) {
            this.training.instructors.splice(instructorIndex, 1)
        }
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
        workload: function() {
            let diff = Math.abs(this.training.beginTime - this.training.endTime) / 36e5;
        
            this.training.beginTime.setSeconds(0)
            this.training.beginTime.setMilliseconds(0)
            this.training.endTime.setSeconds(0)
            this.training.endTime.setMilliseconds(0)

            let workload = model.getWorkloadObject(diff)

            this.training.workload = workload.total

            return workload
        }
    }
}
</script>

<style scoped>
    .times {
        margin-left: 20%;
    }
    
    #workload {
        margin-left: 40%;
    }

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

    #instructors-list {
        margin-left: 2%;
        margin-right: 2%;
    }

    #instructors-list .instructor {
        text-align: center;
    }

    #place-training {
        margin-top: 80px;
    }

    #buttons {
        margin-top: 5%;
    }

    .line {
        text-align: right;
        font-size: 20px;
    }

    .row {
        margin-top: 15px;
    }
</style>
