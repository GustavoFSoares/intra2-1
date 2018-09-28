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
        <div id="buttons">
            <row>
                <router-link class="btn btn-outline-secondary btn-lg" to="" tag="button" @click.native="isValidateForm()">
                    Concluir Análise
                </router-link>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'notificacao-de-incidentes'}" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>
    </div>
</template>

<script>
import model, { getter } from "@/model/incident-reporting-model.js"
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form/index.js"
import Report from "@/entity/incidentReporting";
const GroupModel = require("@/model/group-model").getter
import moment from "moment";

export default {
    data() {
        return {
            id: this.$route.params.id,
            report: new Report(),
            moment: moment,
            reportingEnterprise: '',
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
                }
            }
        }
    },
    methods: {
        loadValues() {
            getter.getIncidentById(this.id).then(res => { 
                this.report = new Report(res)
                this.enterprise.failed = res.failedPlace
            } )
            GroupModel.getEnterprises().then(res => this.options.enterprises = res)
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
            this.report.filtered = true;
            
            model.doUpdate(this.id, this.report).then(res => this.$router.go('-1'))
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

<style scoped>
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
