<template>
    <div class="container">
        <h1>{{ title }}</h1>
        
        <div class="row">

            <div class="col-md-4 order-md-2 mb-4">
                <div id="send">
                    <row>
                        <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" :disabled="options.disabled" data-toggle="modal" data-target="#content-modal">
                            <i v-show="sending" class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                            Enviar Relato
                        </button>
                    </row>
                </div>
                
                <div id="alert-message">
                    <row v-show="email">
                        <alert-message :text="email.text" :type="email.type"/>
                    </row>
                </div>
            </div>

            <div class="col-md-8 order-md-1">
                <form>
                    <div id="return">
                        <row>
                            <label class="" for="same-address">Receber Retorno: </label>
                            <input type="checkbox" class="" name="mustReturn" v-model="report.mustReturn">
                        </row>
                    </div>
            
                    <div id="contact" v-show="report.mustReturn">
                        <hr class="md-4">
                        <div class="mb-3">
                            <h4>{{ subtitles.sender }}</h4>
                            <small class="text-muted">estes dados são opcionais e não serão expostos</small>
                        </div>

                        <div class="row">
                            <rows id="name" label="Nome">
                                <input type="text" class="form-control" name="name" v-model="report.sender.name">
                                <small class="text-muted">Digite seu Nome Completo</small>
                            </rows>

                            <rows id="number" label="Telefone">
                                <input v-mask="['(##) ####-####', '(##) #####-####']" type="tel" class="form-control" name="phone" placeholder="(51) 99999-9999" v-model="report.sender.phonenumber">
                            </rows>
                        </div>

                        <row id="email" label="E-mail">
                            <input data-vv-as="E-mail" v-validate data-vv-rules="email" type="mail" class="form-control" name="email" v-model="report.sender.email">
                            <require-text :error="errors.has('email')" :text="errors.first('email')" :show="true" :attribute="report.sender.email"/>
                        </row>
                    </div>

                    <div id="enterprise">
                        <hr class="md-4">
                        <h4 class="mb-3">{{ subtitles.enterprise }}</h4>
                        <row id="enterprise" label="Selecione a Unidade">
                            <select data-vv-as="Unidade" v-validate data-vv-rules="required" class="custom-select d-block w-100 text-center" @change="loadSectors" name="enterprises" v-model="report.enterprise">
                                <option value=""> </option>
                                <option v-for="enterprise in options.enterprises" :key="enterprise.id" :value="enterprise.id">{{ enterprise.name }}</option>
                            </select>
                            <require-text :error="errors.has('enterprises')" :text="errors.first('enterprises')" :attribute="report.enterprise"/>
                        </row>
                        
                        <row id="sector" label="Selecione o Setor" v-show="report.enterprise == 'hu' || report.enterprise == 'hpsc' ||  report.enterprise == 'upa-rio-branco'">
                            <select class="custom-select d-block w-100 text-center" v-model="report.sector">
                                <option value=""> </option>
                                <option v-for="sector in options.sectors" :key="sector.id" :value="sector.id">{{ sector.name }}</option>
                            </select>
                        </row>
                    </div>

                    <div id="event">
                        <hr class="mb-4">
                        <h4 class="mb-3">{{ subtitles.event }}</h4>
                        <row id="events" label="Selecione o Motivo do Evento">
                            <select data-vv-as="Evento" v-validate data-vv-rules="required" class="custom-select d-block w-100 text-center" name="events" v-model="report.event">
                                <option value=""> </option>
                                <option v-for="event in options.events" :key="event.id" :value="event.id">{{ event.description }}</option>
                            </select>
                            <require-text :error="errors.has('events')" :text="errors.first('events')" :attribute="report.event"/>
                        </row>

                        <row>
                            <textarea data-vv-as="Descrição do Ocorrido" v-validate data-vv-rules="required|min:10|" class="form-control" name="description" cols="30" rows="4" placeholder="Descrição do ocorrido: " v-model="report.complement.description"></textarea>
                            <require-text :error="errors.has('description')" :text="errors.first('description')" :show="true" :attribute="report.complement.description"/>
                        </row>

                        <row>
                            <textarea data-vv-as="Conduta" v-validate data-vv-rules="required|min:10|" class="form-control" name="conduct" cols="30" rows="4" placeholder="Conduta adotada frente ao ocorrido: " v-model="report.complement.conduct"></textarea>
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

                        <div v-show="report.patient.involved">
                            <row id="patientName" label="Nome do Paciente">
                                <input class="form-control" type="text" v-model="report.patient.name">
                            </row>

                            <row id="patientNumber" label="Número de Atendimento do Paciente">
                                <input data-vv-as="Número de Atendimento do Paciente" v-validate data-vv-rules="numeric" class="form-control" type="tel" name="patient-number" v-model="report.patient.number">
                                <require-text :error="errors.has('patient-number')" :text="errors.first('patient-number')" :show="true" :attribute="report.patient.number"/>
                            </row>
                        </div>
                    </div>
                </form>
            </div>

        </div> 
        <modal title="E-mail" submitlabel="Enviar Email" @modal-close="isValidateForm">
            <div class="float-right">
                Enviar Anonimamente: 
                <input type="checkbox" v-model="report.sender.anonymous">
            </div>
            <row label="E-mail">
                <input class="form-control" type="text" v-model="report.sender.email">
            </row>
            <row label="Senha">
                <input class="form-control" type="password" v-model="report.sender.password">
            </row>
            <row></row>
        </modal>
    </div>

</template>

<script>
import model from "@/model/adverse-events"
import { AdverseEventsReport, Mail } from "@/entity";
import { FormRw, FormRws, Require } from "@/components/shared/Form/index.js"
import Modal from "@/components/shared/Modal.vue";
import AlertMessage from "@/components/shared/AlertMessage.vue"

export default {
    data() {
        return {
            title: "Relatar Evento",
            report: AdverseEventsReport,
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
    },
    methods: {
        loadSectors(){
            let id = this.report.enterprise
            if(id == 'hu' || id == 'hpsc' || id == 'upa-rio-branco') {
                model.getSectorsBy(id).then(res => this.options.sectors = res)
            }
        },
        submit() {
            this.options.disabled = true
            this.sending = true
            
            model.sendData(this.report).then(res => {
                    if(res.status){
                        this.email=Mail.success
                        setTimeout(() => { this.$router.push('/') }, 2000)
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

    #submit-button {
        display: block;
        position: fixed;
        top: 40%;
        margin-left: 5%;        
    }

    #alert-message {
        display: block;
        position: fixed;
        top: 25%;
    }

</style>