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
            <h3 class="text-center">{{subtitles.transmissionList}}</h3>
            
            <div class="container">
                
                <label v-if="gotPermission">
                    <b>Adicionar Usuário Responsavel:</b> <input type="checkbox" v-model="addUser">
                </label>
                <row label='Adicionar Usuario' v-if="addUser">
                    <v-select label="name" :options="(values.users)" v-model="userSelected" @input="addUserToTransmissionList()"/>
                </row>
                
                <div id="table" class="list-group">
                    <div v-for="(userAdmin, index) in report.transmissionList" :key="index" class="card">

                        <router-link to="" class="text-left list-group-item list-group-item-action" data-toggle="collapse" :data-target="'#id'+index" aria-expanded="true" :aria-controls="'id'+index">
                            <span class="float-left">{{ userAdmin.name }}</span>
                            <router-link class="float-right" to="" @click.native="removeUserToTransmissionList(userAdmin, index)" v-if="gotPermission">
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
        <row v-if="report.id">
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
                                    <br/>
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
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'notificacao-de-incidentes'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
                <router-link class="btn btn-outline-danger btn-lg" to="" tag="button" v-if="gotPermission && !report.closed" @click.native="closeReport()" :disabled="sending">
                    Finalizar Incidente
                </router-link>
            </row>
        </div>
            
    </div>
</template>

<script>
import model, { getter } from '@/model/incident-reporting-model'
const ModelUser = require('@/model/user-model').default
const GetterUser = require('@/model/user-model').getter
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
            sending: false,
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
            addUser: false,
            userSelected: '',
            groupId: '',
            values: {
                users: [],
            },
            alert: {
                closeReport: {
                    title: "Fechar Chamado?",
                    message: "Ao fechar o chamado você bloqueia todas o chat e para acessa-lo deverá entrar em contato com a TI",
                },
                removeUser: {
                    title: "Deseja Remover esse Usuário?",
                    message: "Ao clicar 'sim' você remove o usuário da Lista de Transmissão. Deseja Continuar?",
                },
            }
        }
    },
    methods: {
        loadValues() {
            getter.getIncidentById(this.id).then(res => { this.report = res ? new Report(res) : new Report() } )
            getter.getHistoricByIncident(this.id).then(res => { this.historic = res; } )
            GetterUser.getUsersAdminWithEmail().then(res => this.values.users = res)
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
        closeReport() {
            Alert.YesNo(this.alert.closeReport.title, this.alert.closeReport.message).then(res => {
                if(res) {
                    this.sending = true
                    model.closeReport(this.id).then(res => {
                        this.$alert.success(`Treinamento <b>#${this.id}</b> Finzalizado`)
                        this.$router.go('-1')
                        this.sending.false
                    }, err => {
                        this.$alert.danger(`Erro ao Finzalizar`)
                        this.sending.false
                    } )
                }
            })
        }
    },
    computed: {
        gotPermission() {
            if(this.permission == 'undefined') {
                model.gotPermission(this.id).then(permission => { this.permission = permission } )
            } else {
                return (this.permission != 'USER' && this.report.id) ? true : false
            }
        }
    },
    mounted() {
        this.loadValues()
    },
    created() {
        model.cleanNotification(this.id, this.$session.get('user').id)
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'chat': require('./Chat.vue').default,
        'v-select': VueSelect
    },
}
</script>

<style lang="scss" scoped>
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

        .time {
            color: rgb(8, 184, 8);
        }
    }
</style>
