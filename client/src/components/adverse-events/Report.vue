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
                            <i v-show="sending" class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                            Enviar Relato
                        </button>
                        
                        <router-link class="button btn btn-outline-primary btn-lg" id="back-button" to="/eventos-adversos" tag="button" :disabled="options.disabled">Voltar</router-link>
                    </row>
                </div>
            </div>

            <div class="col-md-8 order-md-1">
                <form>
                    <div id="return">
                        <row>
                            <label class="" for="same-address">Enviar Anonimamente: </label>
                            <input type="checkbox" class="" name="mustReturn" v-model="report.reporter.anonymous">
                        </row>
                    </div>
            
                    <div id="contact" v-if="!report.reporter.anonymous">
                        <hr class="md-4">
                        <div class="mb-3">
                            <h4>{{ subtitles.sender }}</h4>
                            <small class="text-muted">estes dados são opcionais e não serão expostos</small>
                        </div>

                        <row id="must-return" label="Receber Retorno">
                            <input type="checkbox" class="" name="mustReturn" v-model="report.mustReturn">
                        </row>

                        <div class="row">
                            <rows id="name" label="Nome">
                                <input data-vv-as="Nome" autocomplete="off" v-validate data-vv-rules="required" type="text" class="form-control" name="name" v-model="report.reporter.name">
                                <require-text :error="errors.has('name')" :text="errors.first('name')" :show="true" :attribute="report.reporter.email"/>
                                <small class="text-muted">Digite seu Nome Completo</small>
                            </rows>

                            <rows id="number" label="Telefone">
                                <input v-mask="['(##) ####-####', '(##) #####-####']" autocomplete="off" type="tel" class="form-control" name="phone" placeholder="(51) 99999-9999" v-model="report.reporter.phonenumber">
                            </rows>
                        </div>

                        <row id="email" label="E-mail">
                            <input data-vv-as="E-mail" autocomplete="off" v-validate data-vv-rules="required|email" type="mail" class="form-control" name="email" v-model="report.reporter.email">
                            <require-text :error="errors.has('email')" :text="errors.first('email')" :show="true" :attribute="report.reporter.email"/>
                        </row>
                    </div>

                    <div id="enterprise">
                        <hr class="md-4">
                        <h4 class="mb-3">{{ subtitles.enterprise }}</h4>
                        <row id="enterprise" label="Selecione a Unidade">
                            <v-select v-model="report.enterprise" data-vv-as="Unidade" v-validate data-vv-rules="required" name="enterprises" label="name" :options="options.enterprises"  @input="loadSectors" />
                            <require-text :error="errors.has('enterprises')" :text="errors.first('enterprises')" :attribute="report.enterprise"/>
                        </row>
                        
                        <row id="sector" label="Selecione o Setor" v-if="report.enterprise != null" v-show="report.enterprise.id == 'hu' || report.enterprise.id == 'hpsc' ||  report.enterprise.id == 'upa-rio-branco'">
                            <v-select v-model="report.sector" label="name" :options="options.sectors"/>
                        </row>
                    </div>

                    <div id="event">
                        <hr class="mb-4">
                        <h4 class="mb-3">{{ subtitles.event }}</h4>
                        <row id="events" label="Selecione o Motivo do Evento">
                            <v-select v-model="report.event" data-vv-as="Evento" v-validate data-vv-rules="required" name="events" label="description" :options="options.events"/>
                            <require-text :error="errors.has('events')" :text="errors.first('events')" :attribute="report.event"/>
                        </row>

                        <row>
                            <textarea data-vv-as="Descrição do Ocorrido" v-validate data-vv-rules="required|min:10|max:2000" class="form-control" name="description" cols="30" rows="4" placeholder="Descrição do ocorrido: " v-model="report.complement.description"></textarea>
                            <require-text :error="errors.has('description')" :text="errors.first('description')" :show="true" :attribute="report.complement.description"/>
                        </row>
                        
                        <row label="Data e Hora do Ocorrido">
                            <date-picker id="date" maxdate="now">
                                <input v-mask="'##/##/#### - ##:##'" type="text" class="form-control" id="date"/>
                            </date-picker>
                        </row>

                        <row>
                            <textarea data-vv-as="Conduta" v-validate data-vv-rules="required|min:10|max:2000" class="form-control" name="conduct" cols="30" rows="4" placeholder="Conduta adotada frente ao ocorrido: " v-model="report.complement.conduct"></textarea>
                            <require-text :error="errors.has('conduct')" :text="errors.first('conduct')" :show="true" :attribute="report.complement.conduct"/>
                        </row>
                    </div>

                    <div id="patient">
                        <hr class="mb-4">
                        <h4 class="mb-3">{{subtitles.patient}}</h4>
                        <row id="patientEnvolver" label="Envolveu Paciente">
                            <span>
                                <input type="radio" class="" :value="true" name="patient" v-model="report.patient.involved">Sim
                            </span>
                            
                            <span>
                                <input type="radio" class="" :value="false" name="patient" v-model="report.patient.involved">Não
                            </span>
                        </row>

                        <div v-if="report.patient.involved">
                            <row id="patientName" label="Nome do Paciente">
                                <input class="form-control" type="text" v-model="report.patient.name">
                            </row>

                            <row id="patientNumber" label="Número de Atendimento do Paciente">
                                <input data-vv-as="Número de Atendimento do Paciente" autocomplete="off" v-validate data-vv-rules="numeric|max:8" class="form-control" type="tel" name="patient-number" v-model="report.patient.number">
                                <require-text :error="errors.has('patient-number')" :text="errors.first('patient-number')" :show="true" :attribute="report.patient.number"/>
                            </row>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</template>

<script>
import model from "@/model/adverse-events"
import { AdverseEventsReport } from "@/entity"
import { Mail } from "@/entity/AlertMessage"
import { FormRw, FormRws, Require } from "@/components/shared/Form/index.js"
import Modal from "@/components/shared/Modal.vue"
import AlertMessage from "@/components/shared/AlertMessage.vue"
import DatePicker from "@/components/shared/Form/DatePicker.vue"
import VSelect from "vue-select"

export default {
    data() {
        return {
            title: "Relatar Evento",
            report: new AdverseEventsReport(),
            email: '',
            error: '',
            sending: false,
            options: {
                enterprises: [ ],
                sectors: [ ],
                events: [ ],
                disabled: false
            },
            subtitles: {
                enterprise: 'Unidades',
                event: 'Evento',
                sender: 'Dados Pessoais',
                patient: 'Paciente',
            }
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
        'alert-message': AlertMessage,
        'modal': Modal,
        'v-select': VSelect,
        'date-picker': DatePicker,
    },
    methods: {
        loadSectors(){
            let id = ''
            this.report.enterprise ?
                id = this.report.enterprise.id: id = ''
            
            if(id == 'hu' || id == 'hpsc' || id == 'upa-rio-branco') {
                model.getSectorsBy(id).then(res => this.options.sectors = res)
            }
        },
        submit() {
            this.options.disabled = true
            this.sending = true
            
            this.report.eventTime = document.getElementById('date').value
            model.sendData(this.report).then(res => {
                    if(res.status){
                        this.email=Mail.success
                        setTimeout(() => {
                            this.report = new AdverseEventsReport()
                            
                            this.$router.push('/') 
                        }, 2000)
                    } else {
                        this.options.disabled=false
                        this.email=Mail.failed
                    }
                    this.sending = false
            })
        },
        isValidateForm() {
            this.$validator.validateAll().then(success => success? this.submit():"")
        },
    },
    mounted() {
        model.getEnterprises().then(res => this.options.enterprises = res)
        model.getEvents().then(res => this.options.events = res)
        this.loadSectors()
    },
    
}
</script>

<style scoped>

    #send {
        margin-left: 35px;
    }

    .button {
        display: block;
        position: fixed;
    }

    .button #submit-button {
        margin-top: 40%;
        margin-left: 3%;
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