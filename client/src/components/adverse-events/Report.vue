<template>
    <div class="container">
        <h1>{{ title }}</h1>
        
        <div class="row">

            <div class="col-md-4 order-md-2 mb-4">
                <button class="btn btn-outline-secondary btn-lg" id="submit" type="button" @click="submit">Enviar Relato</button>
            </div>

            <div class="col-md-8 order-md-1">

                <form class="needs-validation" novalidate="">

                    <div id="return">
                        <row >
                            <label class="" for="same-address">Receber Retorno: </label>
                            <input type="checkbox" class="" id="return" v-model="story.mustReturn">
                        </row>
                    </div>
            
                    <div id="contact" v-if="story.mustReturn">

                        <hr class="md-4">

                        <div class="mb-3">
                            <h4>{{ titles.person }}</h4>
                            <small class="text-muted">estes dados são opcionais e não serão expostos</small>
                        </div>

                        <div class="row">
                            <rows id="name" label="Nome">
                                <input type="text" class="form-control" id="name" v-model="story.person.name">
                                <small class="text-muted">Digite seu Nome Completo</small>
                                <div class="invalid-feedback">
                                    Name on card is
                                </div>
                            </rows>

                            <rows id="number" label="Telefone">
                                <input type="tel" class="form-control" id="number" v-model="story.person.phonenumber">
                                <div class="invalid-feedback">
                                    Credit card number is
                                </div>
                            </rows>
                        </div>

                        <row id="email" label="E-mail">
                            <input type="email" class="form-control" id="email" v-model="story.person.email">
                            <div class="invalid-feedback">
                                Credit card number is
                            </div>
                        </row>
                    </div>

                    <div id="unit">
                        <hr class="md-4">

                        <h4 class="mb-3">{{ titles.unit }}</h4>
                        
                        <row id="unit" label="Selecione a Unidade">
                            <select class="custom-select d-block w-100 text-center" @change="loadSectors" id="unit" v-model="story.unit">
                                <option value=""> </option>
                                <option v-for="unit in options.units" :key="unit.value" :value="unit.value">{{ unit.text }}</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </row>
                        <row id="sector" label="Selecione o Setor" v-if="story.unit == 'hu' || story.unit == 'hpsc'">
                            <select class="custom-select d-block w-100 text-center" id="sector" v-model="story.setor">
                                <option value=""> </option>
                                <option v-for="sector in options.sectors" :key="sector.value" :value="sector.value">{{ sector.text }}</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </row>
                    </div>

                    <div id="event">
                        <hr class="mb-4">

                        <h4 class="mb-3">{{ titles.event }}</h4>
                        
                        <row id="events" label="Selecione o Motivo do Evento">
                            <select class="custom-select d-block w-100 text-center" id="events" v-model="story.event">
                                <option value=""> </option>
                                <!-- <option v-for="event in options.events" :key="event.value" :value="event.value">{{ event.text }}</option> -->
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </row>

                        <row>
                            <textarea class="form-control" id="description" cols="30" rows="4" placeholder="Descrição do ocorrido: " v-model="story.complement.description"></textarea>
                        </row>
                        <row>
                            <textarea class="form-control" id="conduct" cols="30" rows="4" placeholder="Conduta adotada frente ao ocorrido: " v-model="story.complement.conduct"></textarea>
                        </row>
                    </div>

                    <div id="patient">
                        <hr class="mb-4">

                        <h4 class="mb-3">{{titles.patient}}</h4>
                        <row id="patientEnvolver" label="Envolveu Paciente">
                                <span>
                                    <input type="radio" class="" :value="true" name="patient" id="return" v-model="story.patient.involved">Sim
                                </span>
                                <span>
                                    <input type="radio" class="" :value="false" name="patient" id="return" v-model="story.patient.involved">Não
                                </span>
                        </row>
                        <row id="patientName" label="Nome do Paciente" v-if="story.patient.involved">
                            <input class="form-control" type="text" v-model="story.patient.name">
                        </row>
                        <row id="patientNumber" label="Número de Atendimento do Paciente" v-if="story.patient.involved">
                            <input class="form-control" type="text" v-model="story.patient.number">
                        </row>
                    </div>
                    
                </form>
            </div>
        </div>    
    </div>

</template>

<script>
import { getSectorsHu, getSectorsHpsc, getUnits, getEvents, buildMail } from "@/model/eventos-adversos"
import { FormRw, FormRws } from "@/components/shared/Form/index.js"
export default {
    data() {
        return {
            title: "Relatar Evento",
            story: {
                mustReturn: '',
                unit: 'hu',
                setor: '',
                event: '',
                complement: {
                    description: '',
                    conduct: '',
                },
                person: {
                    name: '',
                    phonenumber: '',
                    email: '',
                },
                patient: {
                    involved: true,
                    name: "",
                    number: "",
                }
            },
            options: {
                units: [ ],
                sectors: [ ],
                events: [ ],
            },
            titles: {
                unit: 'Unidades',
                event: 'Evento',
                person: 'Dados Pessoais',
                patient: 'Paciente',
            }
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
    },
    methods: {
        loadSectors(){
            if(this.story.unit == 'hu'){
                this.options.sectors = getSectorsHu()
            } else if(this.story.unit == 'hpsc') {
                this.options.sectors = getSectorsHpsc()
            }
        },
        submit() {
           buildMail(this.story);
        }
    },
    mounted() {
        this.options.units = getUnits()
        this.options.events = getEvents();
        this.loadSectors()
    },
    
}
</script>

<style scoped>
    /* .container {
        max-width: 960px;
    } */

    #submit {
        display: block;
        position: fixed;
        top: 40%;
        margin-left: 5%;
    }

</style>