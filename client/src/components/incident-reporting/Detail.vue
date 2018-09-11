<template>
    <div class="container">
        
        <row :label="subtitles.event">
            <h2>#{{report.id}} - {{ report.event.description }}</h2>
        </row>

        <hr>
        <row>
            <div id="description" class="col col-11">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">{{ subtitles.report }}</h6>
                        <p class="card-text">
                            {{ report.description }}
                        </p>
                    </div>
                </div>
            </div>
        </row>
        
        <row >
            <div id="conduct" class="col col-11">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">{{ subtitles.conduct }}</h6>
                        <p class="card-text">
                            {{ report.conduct }}
                        </p>
                    </div>
                </div>
            </div>
        </row>
        
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
        
        <hr>
        <row :label="subtitles.return" v-if="report.mustReturn">
            <h4>{{ report.reporterEmail }}</h4>
            <hr>
        </row>

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
            <rows label="Horário do Relato">
                <p v-if="report.recordTime"> <icon icon="user-clock"/>
                    {{ moment(report.recordTime.date).format('DD/MM/YYYY hh:mm') }}
                </p>
            </rows>
            
            <rows label="Horário do Evento">
                <p v-if="report.failedTime"> <icon icon="clock"/>
                    {{ moment(report.failedTime.date).format('DD/MM/YYYY hh:mm') }}
                </p>
            </rows>
        </div>

        <chat :id="id"/>

        <div id="buttons">
            <row>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'notificacao-de-incidentes'}" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>
            
    </div>
</template>

<script>
import model, { getter } from '@/model/incident-reporting-model'
import Report from "@/entity/incidentReporting";
import { FormRw, FormRws } from "@/components/shared/Form";
import moment from 'moment'

export default {
    data() {
        return {
            id: this.$route.params.id,
            moment: moment,
            report: new Report(),
            subtitles: {
                event: "Tipo do Evento",
                report: "Relato do Incidente:",
                conduct: "Conduta Aplicada:",
                reportPlace: "Setor do Relato",
                failedPlace: "Setor da Falha",
                return: "Enviar Retorno para"
            }
        }
    },
    methods: {
        loadValues() {
            getter.getIncidentById(this.id).then(res => this.report = new Report(res) )
        }
    },
    mounted() {
        this.loadValues()
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'chat': require('./Chat.vue').default
    },
}
</script>

<style scoped>
    #conduct {
        margin-left: 10%;
    }

    .not-active {
        pointer-events: none;
        cursor: default;
        text-decoration: none;
        color: black;
    }
</style>
