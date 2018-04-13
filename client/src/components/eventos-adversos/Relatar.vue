<template>
    <div class="container">
        <h1>{{ title }}</h1>
        <div class="row">

            <div class="col-md-4 order-md-2 mb-4">
                <button class="btn btn-outline-secondary btn-lg" id="submit" type="button" @click="submit">Enviar Relato</button>
            </div>

            <div class="col-md-8 order-md-1">

                <form class="needs-validation" novalidate="">

                    <row id="return">
                        <label class="" for="same-address">Receber Retorno: </label>
                        <input type="checkbox" class="" id="return" v-model="story.mustReturn">
                    </row>

                    <hr class="md-4">

                    <h4 class="mb-3">{{ titles.unit }}</h4>
                    
                    <row id="unit" label="Selecione a Unidade">
                        <select class="custom-select d-block w-100 text-center" @change="loadSectors" id="unit" v-model="story.init">
                            <option value=""> </option>
                            <option v-for="unit in options.units" :key="unit.value" :value="unit.value">{{ unit.text }}</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid country.
                        </div>
                    </row>

                    <row id="sector" label="Selecione o Setor">
                        <select class="custom-select d-block w-100 text-center" id="sector" v-model="story.setor">
                            <option value=""> </option>
                            <option v-for="sector in options.sectors" :key="sector.value" :value="sector.value">{{ sector.text }}</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid country.
                        </div>
                    </row>

                    <hr class="mb-4">

                    <h4 class="mb-3">{{ titles.event }}</h4>
                    
                    <row id="events" label="Selecione o Motivo do Evento">
                        <select class="custom-select d-block w-100 text-center" id="events" v-model="story.event">
                            <option value=""> </option>
                            <option v-for="event in options.events" :key="event.value" :value="event.value">{{ event.text }}</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid country.
                        </div>
                    </row>

                    <row>
                        <textarea class="form-control" id="complement" cols="30" rows="4" placeholder="Complemento: " v-model="story.complement"></textarea>                        
                    </row>

                    <hr class="mb-4">
                    
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
                    
                </form>
            </div>
        </div>    
    </div>

</template>

<script>
import { getSectorsHu, getSectorHpsc, getUnits, getEvents } from "@/model/eventos-adversos"
import { FormRw, FormRws } from "@/components/shared/Form/index.js"
export default {
    data() {
        return {
            title: "Relatar Evento",
            story: {
                mustReturn: '',
                init: 'hu',
                setor: '',
                event: '',
                complement: '',
                person: {
                    name: '',
                    phonenumber: '',
                    email: ''
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
            }
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
    },
    methods: {
        loadSectors(){
            if(this.story.init == 'hu'){
                this.options.sectors = getSectorsHu()
            } else if(this.story.init == 'hpsc') {
                this.options.sectors = getSectorHpsc()
            }
        },
        submit() {
           alert(JSON.stringify(this.story));
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