<template>
    <div class="container">
        
        <row>
            <h2>Análise do Incidente</h2>
        </row>
       <row>
            <h4>
                #{{report.id}} - {{ report.event.description }}
                <span class="closed" v-if="report.closed">(Finalizado)</span>
            </h4>
        </row>

        <div id="enterprise">
            <hr class="md-4">
            <h4 class="mb-3">{{ subtitles.enterprise }}</h4>
            <row>
               <row :label="subtitles.place.failed.enterprise">
                    <v-select v-model="enterprise.failed" data-vv-as="Unidade do Incidente" v-validate data-vv-rules="required" label="enterprise" :options="options.enterprises" name="IncidentReporting-enterprise-failed" @input="loadFailedSectors()"/>
                    <require-text :error="errors.has('IncidentReporting-enterprise-failed')" :text="errors.first('IncidentReporting-enterprise-failed')" :attribute="enterprise.failed"/>
                </row>

                 <row  :label="subtitles.place.failed.group" v-if="enterprise.failed != null && (enterprise.failed.enterprise == 'HU' || enterprise.failed.enterprise == 'HPSC')" id="reportPlace">
                    <v-select v-model="report.place.failedPlace" data-vv-as="Setor da Falha" v-validate data-vv-rules="required" name="IncidentReporting-failedPlace" label="name" :options="options.sectors.failed"/>
                    <require-text :error="errors.has('IncidentReporting-failedPlace')" :text="errors.first('IncidentReporting-failedPlace')" :attribute="report.place.failedPlace"/>
                </row>
            </row>
        </div>

        <hr>
        <div class='row'>
            <rows :label="subtitles.reportPlace">
                <icon class="text-success" icon="pencil-alt"/>
                <div id="reportPlace">
                    <h4>{{ report.place.reportPlace.name }}</h4>
                </div>
            </rows>
            
            <rows :label="subtitles.failedPlace">
                <icon class="text-danger" icon="skull"/>
                <div id="failedPlace">
                    <h4>{{ report.place.failedPlace.name }}</h4>
                </div>    
            </rows>
        </div>

        <div id="event">
            <hr class="md-4">
            <h4 class="mb-3">{{ subtitles.incident }}</h4>
            <row :label="subtitles.report">
                <textarea data-vv-as="Descrição do Ocorrido" v-validate data-vv-rules="required|min:10|max:2000" class="form-control" name="IncidentReporting-description" cols="30" rows="4" placeholder="Descrição do ocorrido: " v-model="report.description"></textarea>
                <require-text :error="errors.has('IncidentReporting-description')" :text="errors.first('IncidentReporting-description')" :show="true" :attribute="report.description"/>
            </row>

            <row :label="subtitles.conduct">
                <textarea data-vv-as="Conduta Adotada" v-validate data-vv-rules="required|min:10|max:2000" class="form-control" name="IncidentReporting-conduct" cols="30" rows="4" placeholder="Conduta adotada frente ao ocorrido: " v-model="report.conduct"></textarea>
                <require-text :error="errors.has('IncidentReporting-conduct')" :text="errors.first('IncidentReporting-conduct')" :show="true" :attribute="report.conduct"/>
            </row>

        </div>

        <div id="patient" class="mb-3">
            <div class="card">

                <div class="card-header" id="patient">
                
                    <h5 class="mb-0">
                        <a class="nav-link collapsed" v-bind:class="{'not-active': !report.patient.involved}" disabled="disabled" data-toggle="collapse" data-target="#patient-content" aria-expanded="false" aria-controls="patient-content">
                            Paciente Envolvido: 
                            <span class="text-success" v-if="report.patient.involved">Sim</span>
                            <span class="text-danger"  v-else>Não</span>
                        </a>
                    </h5>

                </div>
                <div id="patient-content" class="collapse" aria-labelledby="patient">
                    
                    <div class="card-body">
                        <div class='row'>
                            <rows label='Número Atendimento'>
                                {{report.patient.id}}
                            </rows>
                            <rows label='Nome Paciente'>
                                {{report.patient.name}}
                            </rows>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class='row'>
            <rows :label="subtitles.recordTime">
                <p v-if="report.recordTime"> <icon icon="user-clock"/>
                    {{ moment(report.recordTime.date).format('DD/MM/YYYY HH:mm') }}
                </p>
            </rows>
            
            <rows :label="subtitles.failedTime">
                <p v-if="report.failedTime"> <icon icon="clock"/>
                    {{ moment(report.failedTime.date).format('DD/MM/YYYY HH:mm') }}
                </p>
            </rows>
        </div>

        <hr>
        <row>

            <div class="container">
                
                <label>
                    <b>Adicionar Usuário Responsavel:</b> <input type="checkbox" v-model="addUser">
                </label>
                <row label='Adicionar Usuario' v-if="addUser">
                    <v-select label="name" :options="(options.users)" v-model="userSelected" @input="addUserToTransmissionList()"/>
                </row>
                
                <div id="table" class="list-group">
                    <div v-for="(userAdmin, index) in report.transmissionList" :key="index" class="card">

                        <router-link to="" class="text-left list-group-item list-group-item-action" data-toggle="collapse" :data-target="'#id'+index" aria-expanded="true" :aria-controls="'id'+index">
                            <span class="float-left">{{ userAdmin.name }}</span>
                            <router-link class="float-right" to="" @click.native="removeUserToTransmissionList(userAdmin, index)">
                                <icon class="text-danger" icon="minus-circle"/>
                            </router-link>
                        </router-link>

                        <div :id="'id'+index" class="collapse" data-parent="#table">
                            <div class="card">
                                <div class="card-body">
                                
                                        <span class="float-right" v-if="userAdmin.email">{{ userAdmin.email }}</span>
                                        <span class="float-right" v-else><b>Sem email cadastrado</b></span>                                
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            
        </row>

        <hr>
        <div id="buttons">
            <row>
                <router-link class="btn btn-outline-secondary btn-lg" to="" tag="button" @click.native="isValidateForm()" :disabled="sending">
                    Concluir Análise
                </router-link>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'notificacao-de-incidentes'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
            </row>
        </div>
    </div>
</template>

<script>
import model, { getter } from "@/model/incident-reporting-model.js"
const GetterUser = require('@/model/user-model').getter
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form/index.js"
import Report from "@/entity/incidentReporting";
const GroupModel = require("@/model/group-model").getter
import moment from "moment";
import Alert from '@/components/shared/Alert'

export default {
    data() {
        return {
            id: this.$route.params.id,
            report: new Report(),
            moment: moment,
            addUser: '',
            reportingEnterprise: '',
            sending: false,
            enterprise: {
                failed: '',
                report: '',
            },
            subtitles: {
                event: "Tipo do Evento",
                reportPlace: "Setor do Relato",
                failedPlace: "Setor da Falha",
                enterprise: "Unidades",
                event: "Tipo do Evento",
                incident: "Incidente",
                report: "Relato do Incidente",
                conduct: "Conduta Aplicada",
                place: {
                    failed: {
                        enterprise: "Unidade onde ocorreu a falha",
                        group: "Setor onde a falha ocorreu"
                    },
                },
                recordTime: "Horário do Relato",
                failedTime: "Horário do Evento",
            },
            options: {
                groups: [],
                enterprises: [],
                sectors: {
                    failed: [],
                },
                users: []
            },
            userSelected: "",
            alert: {
                removeUser: {
                    title: "Deseja Remover esse Usuário?",
                    message: "Ao clicar 'sim' você remove o usuário da Lista de Transmissão. Deseja Continuar?",
                },
            },
        }
    },
    methods: {
        loadValues() {
            getter.getIncidentById(this.id).then(res => { 
                this.report = new Report(res)
                this.enterprise.failed = res.failedPlace
            } )
            GroupModel.getEnterprises().then(res => this.options.enterprises = res)
            GetterUser.getUsersAdminWithEmail().then(res => this.options.users = res)
        },
        addUserToTransmissionList() {
            if(this.userSelected) {
                var canAdd = true
                model.addUserToTransmissionList(this.id, this.userSelected)
                this.report.transmissionList.forEach(user => {
                    if(user.id == this.userSelected.id) {
                        canAdd = false
                    }
                });

                if(canAdd) {
                    this.report.transmissionList.push(this.userSelected)
                    this.userSelected = null
                }
                
            }
        },
        removeUserToTransmissionList(user, userIndex) {
            
            Alert.YesNo(this.alert.removeUser.title, this.alert.removeUser.message).then(res => {
                if(res) {
                    model.removeUserToTransmissionList(this.id, user)
                    this.report.transmissionList.splice(userIndex, 1)
                }
            })
        },
        loadFailedSectors(){
            let id = this.enterprise.failed ?
                this.enterprise.failed.enterprise : ''
            
            if(id) {
                model.loadSectors(id).then(res => {
                    if(res.sectors) {
                        this.options.sectors.failed = res.value
                    } else if(res.enterprise) {
                        this.report.place.failedPlace = res.value
                    }
                })
            }
        },
        submit() {
            this.sending=true
            this.report.filtered = true;
            
            model.doUpdate(this.id, this.report).then(res => {
                this.$router.go('-1')
                this.$alert.success(`Incidente <b>#${this.id}</b> Filtrado`)
                this.sending = false
            }, err => {
                this.sending = false
                this.$alert.danger(`Erro ao filtrar`)
            })
        },
        isValidateForm() {
            this.$validator.validateAll().then(success => success? this.submit():"")
        },
    },
    mounted() {
        this.loadValues()
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
        'v-select': VueSelect,
    }
}
</script>

<style lang="scss" scoped>
    #title {
        text-align: center;
    }

     #conduct {
        margin-left: 10%;
    }

    .not-active {
        pointer-events: none;
        cursor: default;
        text-decoration: none;
        color: black;
    }

    .closed {
        color: red
    }
</style>
