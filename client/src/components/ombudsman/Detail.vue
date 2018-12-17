<template>
        <div class="container">
        <row>
            <h2>
                #{{ombudsman.id}} - {{ ombudsman.type }} (<i>{{ ombudsman.origin.name }}</i>)
                <span class="closed" v-if="ombudsman.answered">(Finalizado)</span>
            </h2>
        </row>

        <hr>
        <row>
            <div id="patient">
                <div class="card border-secondary">
                    <div class="card-body">
                        <h5 class="card-subtitle mb-2 text-muted">Dados Pessoais:</h5>
                        <row>
                            <div class='row'>
                                <rows label="<b>Nome Paciente</b>">
                                    <span class="card-text">{{ ombudsman.ombudsmanUser.patientName }}</span>
                                </rows>

                                <rows label="<b>Data de Nascimento">
                                    <span class="card-text">{{ ombudsman.ombudsmanUser.birthday }}</span>
                                </rows>
                            </div>
                        </row>

                        <row>
                            <div class='row'>
                                <rows label='<b>Nome do Relatante</b>'>
                                    <span class="card-text"> {{ ombudsman.ombudsmanUser.declarantName }} </span>
                                </rows>
                                
                                <rows label='<b>Telefone</b>'>
                                    <a :href="'tel:'+ombudsman.ombudsmanUser.phoneNumber">{{ ombudsman.ombudsmanUser.phoneNumber }}</a>
                                </rows>
                                
                                <rows label='<b>E-mail</b>'>
                                    <span class="card-text"> {{ ombudsman.ombudsmanUser.email }} </span>
                                </rows>
                            </div>
                        </row>
                        
                        <row label='<b>Endereço</b>'>
                            <span class="card-text"> {{ ombudsman.ombudsmanUser.address }} </span>
                        </row>
                    </div>
                </div>
            </div>
        </row>
        
        <hr>
        <div>
            <row>
                <div id="description" class="col col-11">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Descrição:</h6>
                            <p class="card-text">
                                {{ ombudsman.ombudsmanUserDescription }}
                            </p>
                        </div>
                    </div>
                </div>
            </row>
            
            <row>
                <div id="sugestion" class="col col-11">
                    <div class="card border-secondary">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Sugestão:</h6>
                            <p class="card-text">
                                {{ ombudsman.ombudsmanUserSugestion }}
                            </p>
                        </div>
                    </div>
                </div>
            </row>
        </div>
        
        <hr>
        <row>
            <div class="card border-secondary mb-2">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Demandas:</h6>
                    <div class="row">
                        <div v-for="(demand) in ombudsman.demands" class="col-md-4" :key="demand.id">
                            <p>
                                <icon icon="angle-double-right"/>
                                <span>{{demand.name}}</span>
                            </p>
                        </div>
                    </div>
                    
                    <div v-if="ombudsman.demands.length == 0">
                        <p class="text-center">
                            <b>Sem demandas associadas</b>
                        </p>
                    </div>
                </div>
            </div>
        </row>

        <hr>
        <div class='row'>
            <rows>
                <div v-if="ombudsman.origin.id == 'AMB'">
                    <label>Setor:</label>
                    <p><b>{{ ombudsman.group.name }}</b></p>
                </div>
                <div v-else-if="ombudsman.origin.id == 'INT'">
                    <label>Leito:</label>
                    <p><b>{{ ombudsman.bed }}</b></p>
                </div>
            </rows>

            <rows label="Horário do Relato">
                <p> <icon icon="clock"/>
                    {{ moment(ombudsman.registerTime.date).format('DD/MM/YYYY HH:mm') }}
                </p>
            </rows>
        </div>

        <hr>
        <row>
            <div>
                <div class="card border-secondary">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Relato do Ouvidor:</h6>
                        <p class="card-text">
                            {{ ombudsman.ombudsmanDescription }}
                        </p>
                    </div>
                    
                    <blockquote class="blockquote pull-right signature">
                        <footer class="blockquote-footer">Ouvidor que relatou: 
                            <cite title="Source Title"><b> {{ ombudsman.ombudsman.name }} </b></cite>
                        </footer>
                    </blockquote>
                </div>
            </div>
        </row>

        <hr>
        <section class="mb-3" v-if="ombudsman.id">
            <h4 class="title">Fechamento</h4>
            
            <div class="card border-secondary">
                <div class="card-body">

                    <ombudsman-closing v-if="gotPermission" :ombudsman="ombudsman" ref="closing"/>
                    <manager-closing v-else :ombudsman="ombudsman" ref="closing"/> 

                </div>
            </div>
        </section>
        

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="submit()" :disabled="sending" v-if="ombudsman.status != 'finished'">
                    Registrar Relato
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'ouvidoria'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
            </row>
        </div>
    </div>
</template>

<script>
import Ombudsman from "@/entity/Ombudsman";
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form";
import model, { getter } from '@/model/ombudsman-model'

export default {
    data() {
        return {
            id: this.$route.params.id,
            ombudsman: new Ombudsman( ),
            moment: require('moment'),
            sending: false,
            permission: 'undefined',
            values: {
                groups: [],
                ombudsmans: [],
                demands: [],
            },
        }
    }, 
    methods: {
        
        submit() {
            this.sending = true
            this.$refs.closing.submit().then(res => this.$router.push({ name: 'ouvidoria'}), err => {
                this.sending = false
            })
        },
    },
    computed: {
        gotPermission() {
            if(this.permission == 'undefined') {
                model.gotPermission().then(permission => { this.permission = permission; } )
            } else {
                return (this.permission != 'USER' && this.permission) ? true : false
            }
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'ombudsman-closing': require('./closing/Ombudsman.vue').default,
        'manager-closing': require('./closing/Manager.vue').default,
    },
    mounted() {
        getter.getOmbudsmanById(this.id).then(res => { this.ombudsman = new Ombudsman(res); console.log(res) })
    }
}
</script>

<style>
    .closed {
        color: red;
    }

    #sugestion {
        margin-left: 10%;
    }

    .signature {
        text-align: right;
        margin-right: 20px;
    }
</style>
