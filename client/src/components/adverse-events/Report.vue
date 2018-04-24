<template>
    <div class="container">
        <h1>{{ title }}</h1>
        
        <div class="row">

            <div class="col-md-4 order-md-2 mb-4">
                <div id="send">
                    <row>
                        <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidateForm" :disabled="options.disabled">
                            <i v-show="sending" class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                            Enviar Relato
                        </button>
                    </row>
                </div>
                
                <div id="alert-message">
                    <row v-show="mail">
                        <alert-message :text="mail.text" :type="mail.type"/>
                    </row>
                </div>
            </div>

            <div class="col-md-8 order-md-1">
                <form>
                    <div id="return">
                        <row>
                            <label class="" for="same-address">Receber Retorno: </label>
                            <input type="checkbox" class="" id="return" v-model="story.mustReturn">
                        </row>
                    </div>
            
                    <div id="contact" v-if="story.mustReturn">
                        <hr class="md-4">
                        <div class="mb-3">
                            <h4>{{ subtitles.person }}</h4>
                            <small class="text-muted">estes dados são opcionais e não serão expostos</small>
                        </div>

                        <div class="row">
                            <rows id="name" label="Nome">
                                <input type="text" class="form-control" id="name" v-model="story.person.name">
                                <small class="text-muted">Digite seu Nome Completo</small>
                            </rows>

                            <rows id="number" label="Telefone">
                                <input v-mask="['(##) ####-####', '(##) #####-####']" type="tel" class="form-control" name="phone" placeholder="(51) 99999-9999" v-model="story.person.phonenumber">
                            </rows>
                        </div>

                        <row id="mail" label="E-mail">
                            <input data-vv-as="E-mail" v-validate data-vv-rules="email" type="mail" class="form-control" name="mail" v-model="story.person.mail">
                            <require-text :error="errors.has('mail')" :text="errors.first('mail')" :show="true" :attribute="story.person.mail"/>
                        </row>
                    </div>

                    <div id="enterprise">
                        <hr class="md-4">
                        <h4 class="mb-3">{{ subtitles.enterprise }}</h4>
                        <row id="enterprise" label="Selecione a Unidade">
                            <select data-vv-as="Unidade" v-validate data-vv-rules="required" class="custom-select d-block w-100 text-center" @change="loadSectors" name="enterprises" v-model="story.enterprise">
                                <option value=""> </option>
                                <option v-for="enterprise in options.enterprises" :key="enterprise.value" :value="enterprise.value">{{ enterprise.text }}</option>
                            </select>
                            <require-text :error="errors.has('enterprises')" :text="errors.first('enterprises')" :attribute="story.enterprise"/>
                        </row>
                        
                        <row id="sector" label="Selecione o Setor" v-if="story.enterprise == 'hu' || story.enterprise == 'hpsc'">
                            <select class="custom-select d-block w-100 text-center" id="sector" v-model="story.setor">
                                <option value=""> </option>
                                <option v-for="sector in options.sectors" :key="sector.value" :value="sector.value">{{ sector.text }}</option>
                            </select>
                        </row>
                    </div>

                    <div id="event">
                        <hr class="mb-4">
                        <h4 class="mb-3">{{ subtitles.event }}</h4>
                        <row id="events" label="Selecione o Motivo do Evento">
                            <select data-vv-as="Evento" v-validate data-vv-rules="required" class="custom-select d-block w-100 text-center" name="events" v-model="story.event">
                                <option value=""> </option>
                                <option v-for="event in options.events" :key="event.text" :value="event.value">{{ event.text }}</option>
                            </select>
                            <require-text :error="errors.has('events')" :text="errors.first('events')" :attribute="story.event"/>
                        </row>

                        <row>
                            <textarea data-vv-as="Descrição do Ocorrido" v-validate data-vv-rules="required|min:10|" class="form-control" name="description" cols="30" rows="4" placeholder="Descrição do ocorrido: " v-model="story.complement.description"></textarea>
                            <require-text :error="errors.has('description')" :text="errors.first('description')" :show="true" :attribute="story.complement.description"/>
                        </row>

                        <row>
                            <textarea data-vv-as="Conduta" v-validate data-vv-rules="required|min:10|" class="form-control" name="conduct" cols="30" rows="4" placeholder="Conduta adotada frente ao ocorrido: " v-model="story.complement.conduct"></textarea>
                            <require-text :error="errors.has('conduct')" :text="errors.first('conduct')" :show="true" :attribute="story.complement.conduct"/>
                        </row>
                    </div>

                    <div id="patient">
                        <hr class="mb-4">
                        <h4 class="mb-3">{{subtitles.patient}}</h4>
                        <row id="patientEnvolver" label="Envolveu Paciente">
                            <span>
                                <input type="radio" class="" :value="true" name="patient" id="return" v-model="story.patient.involved">Sim
                            </span>
                            
                            <span>
                                <input type="radio" class="" :value="false" name="patient" id="return" v-model="story.patient.involved">Não
                            </span>
                        </row>

                        <div v-if="story.patient.involved">
                            <row id="patientName" label="Nome do Paciente">
                                <input class="form-control" type="text" v-model="story.patient.name">
                            </row>

                            <row id="patientNumber" label="Número de Atendimento do Paciente">
                                <input data-vv-as="Número de Atendimento do Paciente" v-validate data-vv-rules="numeric" class="form-control" type="tel" name="patient-number" v-model="story.patient.number">
                                <require-text :error="errors.has('patient-number')" :text="errors.first('patient-number')" :show="true" :attribute="story.patient.number"/>
                            </row>
                        </div>
                    </div>
                </form>
            </div>

        </div> 
        
    </div>

</template>

<script>
import { getSectorsHu, getSectorsHpsc, getEnterprises, getEvents, sendData } from "@/model/adverse-events"
import { AdverseEventsStory, Mail } from "@/entity";
import { FormRw, FormRws, Require } from "@/components/shared/Form/index.js"
import Modal from "@/components/shared/Modal.vue";
import AlertMessage from "@/components/shared/AlertMessage.vue"

export default {
    data() {
        return {
            title: "Relatar Evento",
            story: AdverseEventsStory,
            mail: '',
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
                person: 'Dados Pessoais',
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
            if(this.story.enterprise == 'hu'){
                this.options.sectors = getSectorsHu()
            } else if(this.story.enterprise == 'hpsc') {
                this.options.sectors = getSectorsHpsc()
            }
        },
        submit() {
            this.options.disabled = true;
            this.sending = true
            
            sendData(this.story).then(res => {
                    if(res.status){
                        this.mail=Mail.success
                        setTimeout(() => { this.$router.push('/') }, 2000)
                    } else {
                        this.options.disabled=false
                        this.mail=Mail.failed
                    }
                    this.sending = false
            })
        },
        isValidateForm() {
            this.$validator.validateAll().then(success => success? this.submit():"")
        },
        
    },
    mounted() {
        this.options.enterprises = getEnterprises()
        this.options.events = getEvents();
        this.loadSectors()
    },
    
}
</script>

<style scoped>
    /* .container {
        max-width: 960px;
    } */

    #submit-button {
        display: block;
        position: fixed;
        top: 40%;
        margin-left: 5%;
    }

    #send {
        position: absolute
    }

</style>