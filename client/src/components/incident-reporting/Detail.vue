<template>
    <div class="container">
        
        <row>
            <h2>
                #{{report.id}} - {{ report.event.description }}
                <span class="closed" v-if="report.closed">(Finalizado)</span>
            </h2>
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
            <rows :label="subtitles.recordTime">
                <p v-if="report.recordTime"> <icon icon="user-clock"/>
                    {{ moment(report.recordTime.date).format('DD/MM/YYYY hh:mm') }}
                </p>
            </rows>
            
            <rows :label="subtitles.failedTime">
                <p v-if="report.failedTime"> <icon icon="clock"/>
                    {{ moment(report.failedTime.date).format('DD/MM/YYYY hh:mm') }}
                </p>
            </rows>
        </div>

        <hr>
        <row>
            <h3 class="text-center">{{subtitles.transmissionList}}</h3>
            
            <div class="container">
                
                <label v-if="gotPermission">
                    <b>Adicionar Grupo Responsavel:</b> <input type="checkbox" v-model="addGroups" @change="loadGroups()">
                </label>
                <row label='Adicionar Grupo' v-if="addGroups">
                    <v-select label="name" :options="(values.groups)" v-model="groupSelected" @input="addGroupToTransmissionList()"/>
                </row>
                
                 <div id="table" class="list-group">
                    <div v-for="(transmissionGroup, index) in report.transmissionList" :key="index" class="card">

                        <router-link to="" class="text-left list-group-item list-group-item-action" data-toggle="collapse" :data-target="'#id'+transmissionGroup.id" aria-expanded="true" :aria-controls="'id'+transmissionGroup.id" @click.native="loadUserForGroup(transmissionGroup.id)">
                            <span class="float-left">{{ transmissionGroup.name }}</span>
                            <router-link class="float-right" to="" @click.native="removeGroupToTransmissionList(transmissionGroup, index)" v-if="gotPermission">
                                <icon class="text-danger" icon="minus-circle"/>
                            </router-link>
                        </router-link>

                        <div :id="'id'+transmissionGroup.id" class="collapse" data-parent="#table">
                            <div class="card-body">
                                
                                <div id="users" v-if="transmissionGroup.id == groupId">
                                    <div class="container">
                                        <div class="list-group  list-group-flush">
                                            
                                            <div class="list-group-item" v-for="(user, index) in values.users" :key="`g${transmissionGroup.id}u${index}`">
                                                <span class="float-left">{{ user.name }}</span>
                                                <span class="float-right" v-if="user.email">{{ user.email }}</span>
                                                <span class="float-right" v-else><b>Sem email cadastrado</b></span>
                                            </div>
                                            
                                            <div class="list-group-item disabled" v-if="values.users.length == 0 && values.users">
                                                <span class="">Nenhum usuário encontrado</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </row>

        <hr>
        <row>
            <chat :id="`ir${id}`" v-if="!report.closed"/>
            <div v-else >
                <div>
                    <div class="card">
                        <div class="card-body historic">
                            <h6 class="card-subtitle mb-2 text-muted">{{ subtitles.historic }}:</h6>
                            <div class="card-text">
                                <span class="historic-body" v-for="(line, index) of historic" :key="index">
                                    <span class="time">{{ line.time }}</span>
                                    <span class="user">{{ line.user }}:</span>
                                    <span class="message">{{ line.message }}</span>
                                    <br>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </row>

        <hr>
        <div id="buttons">
            <row>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'notificacao-de-incidentes'}" tag="button">
                    Voltar
                </router-link>
                <router-link class="btn btn-outline-danger btn-lg" to="" tag="button" v-if="gotPermission && !report.closed" @click.native="closeReport()">
                    Finalizar Incidente
                </router-link>
            </row>
        </div>
            
    </div>
</template>

<script>
import model, { getter } from '@/model/incident-reporting-model'
const ModelGroup = require('@/model/group-model').getter
const ModelUser = require('@/model/user-model').default
import Report from "@/entity/incidentReporting";
import { FormRw, FormRws, VueSelect } from "@/components/shared/Form";
import Alert from '@/components/shared/Alert'
import moment from 'moment'

export default {
    data() {
        return {
            id: this.$route.params.id,
            moment: moment,
            report: new Report(),
            group: this.$session.get('user').group,
            permission: 'undefined',
            historic: 'undefined',
            subtitles: {
                event: "Tipo do Evento",
                report: "Relato do Incidente:",
                conduct: "Conduta Aplicada:",
                historic: "Histórico do Relato",
                reportPlace: "Setor do Relato",
                failedPlace: "Setor da Falha",
                return: "Enviar Retorno para",
                recordTime: "Horário do Relato",
                failedTime: "Horário do Evento",
                transmissionList: "Acompanhamento do Incidente",
            },
            addGroups: false,
            groupSelected: '',
            groupId: '',
            values: {
                groups: [],
                users: [],
            },
            alert: {
                closeReport: {
                    title: "Fechar Chamado?",
                    message: "Ao fechar o chamado você bloqueia todas o chat e para acessa-lo deverá entrar em contato com a TI",
                },
                removeGroup: {
                    title: "Deseja Remover esse grupo?",
                    message: "Ao clicar 'sim' você remove o grupo da Lista de Transmissão. Deseja Continuar?",
                },
            }
        }
    },
    methods: {
        loadValues() {
            getter.getIncidentById(this.id).then(res => { this.report = new Report(res) } )
            getter.getHistoricByIncident(this.id).then(res => { this.historic = res; } )
        },
        loadGroups() {
            if(this.addGroups) {
                ModelGroup.getGroups().then(res => this.values.groups = res)
            }
        },
        addGroupToTransmissionList() {
            if(this.groupSelected) {
                model.addGroupToTransmissionList(this.id, this.groupSelected)
                this.report.transmissionList.push(this.groupSelected)
            }
        },
        removeGroupToTransmissionList(group, groupIndex) {
            
            Alert.YesNo(this.alert.removeGroup.title, this.alert.removeGroup.message).then(res => {
                if(res) {
                    model.removeGroupToTransmissionList(this.id, group)
                    this.report.transmissionList.splice(groupIndex, 1)
                }
            })
        },
        loadUserForGroup(groupId) {
            this.groupId = groupId
            this.values.users = ''

            ModelUser.loadUsers(this.groupId).then(res => this.values.users = res)
        },
        closeReport() {
            Alert.YesNo(this.alert.closeReport.title, this.alert.closeReport.message).then(res => {
                if(res) {
                    model.closeReport(this.id).then(res => this.$router.go('-1') )
                }
            })
        }
    },
    computed: {
        gotPermission() {
            if(this.permission == 'undefined') {
                model.gotPermission(this.group).then(permission => this.permission = permission )
            } else {
                return this.permission
            }
        }
    },
    mounted() {
        this.loadValues()
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'chat': require('./Chat.vue').default,
        'v-select': VueSelect
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

    .closed {
        color: red;
        
    }

    .historic {
        background-color: rgba(224, 224, 224, 0.425);
    }

    .historic-body {
        font-size: 15px;
    }

    .historic-body .time {
        color: rgb(8, 184, 8);
    }

</style>
