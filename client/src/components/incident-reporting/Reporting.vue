<template>
    <div class="container">
        <h1>{{ title }}</h1>

        <div id="alert-message">
            <row v-show="email">
                <alert-message :text="email.text" :type="email.type" test='123'/>
            </row>
        </div>
        
        <div class="row">

            <div class="col-md-4 order-md-2 mb-4">
                <div id="send">
                    <row>
                        <button class="button btn btn-outline-secondary btn-lg" id="submit-button" type="button" :disabled="options.disabled" @click="isValidateForm">
                            <icon v-show="sending" icon="spinner" spin style="font-size:26px"/>
                            Enviar Relato
                        </button>
                        
                        <router-link class="button btn btn-outline-primary btn-lg" id="back-button" :to="{name: 'notificacao-de-incidentes/help'}" tag="button" :disabled="options.disabled">Voltar</router-link>
                    </row>
                </div>
            </div>

            <div class="col-md-8 order-md-1">
                <form>
                    <div id="return">
                        <row label="Enviar Anonimamente">
                            <input type="checkbox" class="" name="mustReturn" v-model="anonymous">
                        </row>
                    </div>
            
                    <div id="contact" v-if="!anonymous">
                        <hr class="md-4">
                        <div class="mb-3">
                            <h4>{{ subtitles.sender }}</h4>
                        </div>

                        <row id="must-return" label="Receber Retorno">
                            <input type="checkbox" class="" name="mustReturn" v-model="report.mustReturn">
                        </row>

                        <row id="email" label="E-mail">
                            <input data-vv-as="E-mail" autocomplete="off" v-validate data-vv-rules="required|email" type="mail" class="form-control" name="IncidentReporting-email" v-model="report.reporterEmail">
                            <require-text :error="errors.has('IncidentReporting-email')" :text="errors.first('IncidentReporting-email')" :show="true" :attribute="report.reporterEmail"/>
                        </row>
                    </div>

                    <div id="enterprise">
                        <hr class="md-4">
                        <h4 class="mb-3">{{ subtitles.enterprise }}</h4>
                        <row>
                            <row :label="subtitles.report.enterprise">
                                <v-select v-model="enterprise.report" data-vv-as="Unidade da notificação" v-validate data-vv-rules="required" label="enterprise" :options="options.enterprises" name="IncidentReporting-enterprise-report" @input="loadReportSectors()"/>
                                <require-text :error="errors.has('IncidentReporting-enterprise-report')" :text="errors.first('IncidentReporting-enterprise-report')" :attribute="enterprise.report"/>
                            </row>

                            <row  :label="subtitles.report.group" v-if="enterprise.report != null && (enterprise.report.enterprise == 'HU' || enterprise.report.enterprise == 'HPSC')" id="reportPlace">
                                <v-select v-model="report.place.reportPlace" data-vv-as="Setor do Relato" v-validate data-vv-rules="required" name="IncidentReporting-reportPlace" label="name" :options="options.sectors.report"/>
                                <require-text :error="errors.has('IncidentReporting-reportPlace')" :text="errors.first('IncidentReporting-reportPlace')" :attribute="report.place.reportPlace"/>
                            </row>
                        </row>
                        
                        <row>
                            <row :label="subtitles.failed.enterprise">
                                <v-select v-model="enterprise.failed" data-vv-as="Unidade do Incidente" v-validate data-vv-rules="required" label="enterprise" :options="options.enterprises" name="IncidentReporting-enterprise-failed" @input="loadFailedSectors()"/>
                                <require-text :error="errors.has('IncidentReporting-enterprise-failed')" :text="errors.first('IncidentReporting-enterprise-failed')" :attribute="enterprise.failed"/>
                            </row>

                            <row  :label="subtitles.failed.group" v-if="enterprise.failed != null && (enterprise.failed.enterprise == 'HU' || enterprise.failed.enterprise == 'HPSC')" id="reportPlace">
                                <v-select v-model="report.place.failedPlace" data-vv-as="Setor da Falha" v-validate data-vv-rules="required" name="IncidentReporting-failedPlace" label="name" :options="options.sectors.failed"/>
                                <require-text :error="errors.has('IncidentReporting-failedPlace')" :text="errors.first('IncidentReporting-failedPlace')" :attribute="report.place.failedPlace"/>
                            </row>
                        </row>
                    </div>

                    <div id="event">
                        <hr class="mb-4">
                        <h4 class="mb-3">{{ subtitles.event }}</h4>
                        <row id="events" label="Motivo do Evento">
                            <v-select v-model="report.event" data-vv-as="Evento" v-validate data-vv-rules="required" name="IncidentReporting-event" label="description" :options="options.events"/>
                            <require-text :error="errors.has('IncidentReporting-event')" :text="errors.first('IncidentReporting-event')" :attribute="report.event"/>
                        </row>

                        <row>
                            <textarea data-vv-as="Descrição do Ocorrido" v-validate data-vv-rules="required|min:10|max:2000" class="form-control" name="IncidentReporting-description" cols="30" rows="4" placeholder="Descrição do ocorrido: " v-model="report.description"></textarea>
                            <require-text :error="errors.has('IncidentReporting-description')" :text="errors.first('IncidentReporting-description')" :show="true" :attribute="report.description"/>
                        </row>
                        
                        <row label="Data e Hora que ocorreu a falha">
                            <date-picker id="date" maxdate="now">
                                <input v-mask="'##/##/#### - ##:##'" type="text" class="form-control" id="date"/>
                            </date-picker>
                        </row>

                        <row>
                            <textarea data-vv-as="Conduta Adotada" v-validate data-vv-rules="required|min:10|max:2000" class="form-control" name="IncidentReporting-conduct" cols="30" rows="4" placeholder="Conduta adotada frente ao ocorrido: " v-model="report.conduct"></textarea>
                            <require-text :error="errors.has('IncidentReporting-conduct')" :text="errors.first('IncidentReporting-conduct')" :show="true" :attribute="report.conduct"/>
                        </row>
                    </div>

                    <div id="patient">
                        <hr class="mb-4">
                        <h4 class="mb-3">{{subtitles.patient}}</h4>
                        <row id="patientEnvolver" label="Envolveu Paciente">
                            <span>
                                <input type="radio" class="" :value="true" name="IncidentReporting-patientInvolved" v-model="report.patient.involved">Sim
                            </span>
                            
                            <span>
                                <input type="radio" class="" :value="false" name="IncidentReporting-patientInvolved" v-model="report.patient.involved">Não
                            </span>
                        </row>

                        <div v-if="report.patient.involved">
                            <row id="patientName" label="Nome do Paciente">
                                <input class="form-control" name="IncidentReporting-patientName" type="text" v-model="report.patient.name">
                            </row>

                            <row id="patientNumber" label="Número de Atendimento do Paciente">
                                <input data-vv-as="Número de Atendimento do Paciente" autocomplete="off" v-validate data-vv-rules="numeric|max:8" class="form-control" type="tel" name="IncidentReporting-patientId" v-model="report.patient.id">
                                <require-text :error="errors.has('IncidentReporting-patientId')" :text="errors.first('IncidentReporting-patientId')" :show="true" :attribute="report.patient.id"/>
                            </row>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</template>

<script>
import model, { getter } from "@/model/incident-reporting-model.js"
import IncidentReporting from "@/entity/incidentReporting"
import { Mail } from "@/entity/AlertMessage"
import { FormRw, FormRws, Require, VueSelect, DatePicker } from "@/components/shared/Form/index.js"
import Modal from "@/components/shared/Modal.vue"
import AlertMessage from "@/components/shared/AlertMessage.vue"
const GroupModel = require("@/model/group-model").getter
export default {
    data() {
        return {
            title: "Relatar Evento",
            reportingEnterprise: '',
            enterprise: {
                failed: '',
                report: '',
            },
            anonymous: '',
            report: new IncidentReporting(),
            email: '',
            error: '',
            sending: false,
            options: {
                enterprises: [ ],
                sectors: {
                    failed: [],
                    report: [],
                },
                events: [ ],
                disabled: false
            },
            subtitles: {
                enterprise: 'Unidades',
                event: 'Evento',
                sender: 'Dados Pessoais',
                patient: 'Paciente',
                report: {
                    enterprise: "Unidade que está sendo realizado a notificação",
                    group: "Setor que está realizando a notificação"
                },
                failed: {
                    enterprise: "Unidade onde ocorreu a falha",
                    group: "Setor onde a falha ocorreu"
                },
            }
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
        'alert-message': AlertMessage,
        'modal': Modal,
        'v-select': VueSelect,
        'date-picker': DatePicker,
    },
    methods: {
        loadFailedSectors(){
            let id = this.enterprise.failed ?
                this.enterprise.failed.enterprise : ''
            
            if(id) {
                model.loadSectors(id).then(res => {
                    if(res.sectors) {
                        this.report.place.failedPlace = ''
                        this.options.sectors.failed = res.value
                    } else if(res.enterprise) {
                        this.report.place.failedPlace = res.value
                    }
                })
            }
        },
        loadReportSectors(){
            let id = this.enterprise.report ?
                this.enterprise.report.enterprise : ''
            
            if(id) {
                model.loadSectors(id).then(res => {
                    if(res.sectors) {
                        this.report.place.reportPlace = ''
                        this.options.sectors.report = res.value
                    } else if(res.enterprise) {
                        this.report.place.reportPlace = res.value
                    }
                })
            }
        },
        submit() {
            this.options.disabled = true
            this.sending = true
            
            this.report.failedTime = document.getElementById('date').value
            model.doInsert(this.report).then(res => {
                this.email=Mail.success
                setTimeout(() => {
                    this.report = new IncidentReporting()
                    
                    this.$router.push('/') 
                    this.sending = false
                }, 2000)
            }, err => {
                this.options.disabled=false
                this.email=Mail.failed
                this.sending = false
            })
        },
        isValidateForm() {
            this.$validator.validateAll().then(success => success? this.submit():"")
        },
        loadValues() {
            GroupModel.getEnterprises().then(res => this.options.enterprises = res)
            getter.getEvents().then(res => this.options.events = res)
        }
    },
    mounted() {
        this.loadValues()
    },
    
}
</script>

<style lang="scss" scoped>

    #send {
        margin-left: 35px;
    }

    .button {
        display: block;
        position: fixed;

        #submit-button {
            margin-top: 40%;
            margin-left: 3%;
        }
    }

    #back-button {
        margin-top: 60px;
        margin-left: 2%;
    }

    #alert-message {
        display: block;
        position: fixed;
        z-index: 1;

        top: 10;
        left: 2%;
        width: 95%;
    }

</style>