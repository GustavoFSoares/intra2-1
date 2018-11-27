<template>
    <div class="container">
        <h1>{{ title }}</h1>

        <div v-uiv-scrollspy:form>
            <li v-for="section in sections" :key="section.id" class="active"><a :href="`#${section.id}`">@{{ section.label }}</a></li>
        </div>

        <div class="scroll-container" id="form">
            <section id="code">
                <row :label="sections.code.label">
                    <v-select v-model="ombudsman.id" data-vv-as="Unidade da notificação" v-validate data-vv-rules="required" label="id" :options="values.ombudsmans" name="IncidentReporting-enterprise-report"/>
                </row>
            </section>

            <section :id="sections.userInformations.id" class="mb-3">
                <div id="user-informations-title">
                    <h4 class="title">{{ sections.userInformations.label }}</h4>
                </div>
                
                <div id="user-informations-person" class="card border-secondary mb-2">
                    <div class="card-body">
                        
                        <div>
                            <h5 class="subtitle">Dados Pessoais:</h5>
                        </div>
                        <hr>

                        <div class='row'>
                            <rows label="Nome Paciente" class="col-md-7">
                                <input type="text" class="form-control" v-model="ombudsman.ombudsmanUser.patientName">
                            </rows>

                            <rows label='Aniversario'>
                                <input type="text" class="form-control" v-mask="'##/##/####'" name="mustReturn" v-model="ombudsman.ombudsmanUser.birthday">
                            </rows>
                            
                            <rows label='Telefone'>
                                <input type="text" class="form-control" v-mask="'(##) #####-####'" v-model="ombudsman.ombudsmanUser.phoneNumber">
                            </rows>
                        </div>

                        <div class='row'>
                            <rows label='Nome relatante'>
                                <input type="text" class="form-control" v-model="ombudsman.ombudsmanUser.declarantName">
                            </rows>

                            <rows label='Email Relatante'>
                                <input type="text" class="form-control" v-model="ombudsman.ombudsmanUser.email">
                            </rows>
                        </div>

                    </div>
                </div>

                <div id="user-information-address" class="card border-secondary">
                    <div class="card-body">

                        <div>
                            <h5 class="subtitle">Endereço:</h5>
                        </div>
                        <hr>

                        <div class='row'>
                            <rows label='Rua' class="col-md-3">
                                <input type="text" class="form-control" v-model="address.street">
                            </rows>
                            
                            <rows label='Nº' class="col-md-1">
                                <input type="text" class="form-control" v-model="address.number">
                            </rows>

                            <rows label='Bairro' class="col-md-3">
                                <input type="text" class="form-control" v-model="address.neighborhood">
                            </rows>

                            <rows label='Cidade'>
                                <input type="text" class="form-control" v-model="address.city">
                            </rows>

                            <rows label='CEP'>
                                <input type="text" v-mask="'#####-###'" class="form-control" v-model="address.postCode">
                            </rows>
                        </div>

                    </div>
                </div>
            </section>

            <section :id="sections.type.id" class="mb-3">
                <div class="row">
                    <rows v-for="(type, index) in types" :key="index">
                        <input type="radio" :value="type.name" v-model="ombudsman.type" :name="index">
                        <label :for="index">{{ type.name }}</label>
                    </rows>
                </div>
            </section>

            <section :id="sections.report.id" class="mb-3">
                <div>
                    <h4 class="title">{{ sections.report.label }}</h4>
                </div>
                <hr>

                <div class="card border-secondary mb-2">
                    <div class="card-body">

                        <div id="report-description" class="mb-4">
                            
                            <div>
                                <h5 class="subtitle">Descrição: (Relatar o ocorrido)</h5>
                            </div>
                            <hr>

                            <row>
                                <textarea class="form-control" cols="30" rows="4" v-model="ombudsman.description" placeholder="Descrição: "></textarea>
                            </row>

                        </div>

                        <div id="report-sugestion">

                            <div>
                                <h5 class="subtitle">Sugestão/Solicitação:</h5>
                            </div>
                            <hr>

                            <row>
                                <textarea class="form-control" cols="30" rows="4" v-model="ombudsman.sugestion" placeholder="Sugestão: "></textarea>
                            </row>

                        </div>

                    </div>
                </div>
            </section>

            <section :id="sections.ombudsmanReport.id" class="mb-3">
                <div>
                    <h4 class="title">{{ sections.ombudsmanReport.label }}</h4>
                </div>
                
                <div class="card border-secondary">
                    <div class="card-body">

                        <div>
                            <h5 class="subtitle">Informação complementar do Ouvidor:</h5>
                        </div>
                        <hr>

                        <row>
                            <textarea class="form-control" cols="30" rows="4" v-model="ombudsman.ombudsmanDescription" placeholder="Informações do Ouvidor: "></textarea>
                            <!-- <require-text :error="errors.has('IncidentReporting-conduct')" :text="errors.first('IncidentReporting-conduct')" :show="true" :attribute="report.conduct"/> -->
                        </row>                        
                        
                    </div>
                
                    <blockquote class="blockquote pull-right" id="ombudsman-logged">
                        <footer class="blockquote-footer">Você está logado como
                            <cite title="Source Title"><b> {{ $session.get('user').name }} </b></cite>
                        </footer>
                    </blockquote>
                </div>
            </section>

        </div>
    </div>
</template>

<script>
import model, { getter } from '@/model/ombudsman-model'
const ModelUser = require('@/model/user-model').default
const GetterUser = require('@/model/user-model').getter
import Ombudsman from "@/entity/Ombudsman";
import { FormRw, FormRws, VueSelect } from "@/components/shared/Form";
import Alert from '@/components/shared/Alert'
import moment from 'moment'

export default {
    data() {
        return {
            id: this.$route.params.id,
            title: "Registro de Ouvidorias",
            moment: moment,
            ombudsman: new Ombudsman(),
            address: {},
            types: [
                { name: 'Denúncia', },
                { name: 'Solicitação', },
                { name: 'Reclamação', },
                { name: 'Sugestão', },
                { name: 'Elogio', },
                { name: 'Outros', },
            ],
            sections: {
                code: { id: "code", label: "Código"},
                userInformations: { id: "user-informations", label: "Dados do Relator"},
                type: { id: "ombudsman-type", label: "Tipos de Ouvidoria"},
                report: { id: "report", label: "Relato"},
                ombudsmanReport: { id: "ombudsman-report", label: "Ouvidor"},
            },
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
                ombudsmans: [],
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
            getter.getOmbudsmansWaiting().then(res => { this.values.ombudsmans = res; console.log(res) })
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
                    model.closeReport(this.id).then(res => this.$router.go('-1') )
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
        // model.cleanNotification(this.id, this.$session.get('user').id)
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'v-select': VueSelect
    },
}
</script>

<style scoped>
    .subtitle {
        text-align: left;
        font-size: 17px;
    }

    #ombudsman-logged {
        text-align: right;
        margin-right: 20px;
    }

</style>
