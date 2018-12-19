<template>
        <div class="container">
        
        <h3 class="text-danger text-right" v-if="permission == 'COMPANION'">Você está acompanhando!</h3>
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
        <section class="mb-3" v-if="gotAdminPermission">
            <h4 class="title">Lista de Acompanhantes</h4>
            
            <div class="card border-secondary">
                <div class="card-body">
                    <add-users :manager_list="ombudsman.managerList" :tranmission_list="ombudsman.transmissionList" v-if="gotAdminPermission" @sendUser="addUser" />
                    <!-- <ombudsman-closing v-if="gotAdminPermission" :ombudsman="ombudsman" ref="closing"/> -->
                    <!-- <manager-closing v-else :ombudsman="ombudsman" ref="closing"/>  -->

                    <div class='row'>
                        <rows>
                            
                            <h4 class="title">Lista de Responsáveis:</h4>
                            <div id="manager" class="list-group">
                                <div v-for="(userAdmin, index) in ombudsman.managerList" :key="index" class="card">

                                    <router-link to="" class="text-left list-group-item list-group-item-action" data-toggle="collapse" :data-target="'#id-m'+index" aria-expanded="true" :aria-controls="'id-m'+index">
                                        <span class="float-left">{{ userAdmin.name }}</span>
                                        <router-link class="float-right" to="" v-if="gotAdminPermission" @click.native="removeUser(userAdmin, index, 'manager')">
                                            <icon class="text-danger" icon="minus-circle"/>
                                        </router-link>
                                    </router-link>

                                    <div :id="'id-m'+index" class="collapse" data-parent="#manager">
                                        <div class="card">
                                            <div class="card-body">
                                                <span class="float-right" v-if="userAdmin.email">{{ userAdmin.email }}</span>
                                                <span class="float-right" v-else><b>Sem email cadastrado</b></span>                                
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <h5 class="text-danger" v-if="ombudsman.managerList.length == 0"> Nenhum Responsável Adicionado </h5>
                            </div>

                        </rows>
                        <rows>
                            
                            <h4 class="title">Observando:</h4>
                            <div id="companion" class="list-group">
                                <div v-for="(userAdmin, index) in ombudsman.transmissionList" :key="index" class="card">

                                    <router-link to="" class="text-left list-group-item list-group-item-action" data-toggle="collapse" :data-target="'#id-c'+index" aria-expanded="true" :aria-controls="'id-c'+index">
                                        <span class="float-left">{{ userAdmin.name }}</span>
                                        <router-link class="float-right" to="" v-if="gotAdminPermission" @click.native="removeUser(userAdmin, index, 'companion')">
                                            <icon class="text-danger" icon="minus-circle"/>
                                        </router-link>
                                    </router-link>

                                    <div :id="'id-c'+index" class="collapse" data-parent="#companion">
                                        <div class="card">
                                            <div class="card-body">
                                                <span class="float-right" v-if="userAdmin.email">{{ userAdmin.email }}</span>
                                                <span class="float-right" v-else><b>Sem email cadastrado</b></span>                                
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <h5 class="text-danger" v-if="ombudsman.transmissionList.length == 0"> Nenhum Observador Adicionado </h5>
                            </div>

                        </rows>
                    </div>
                    
                </div>
            </div>
        </section>

        <div class="mt-3 mb-3">
            <chat :id="'om'+id" model_path="ombudsman-model" v-if="ombudsman.exist()" :can_write="permission != 'COMPANION'"/>
        </div>
        
        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="submit()" :disabled="sending" v-if="ombudsman.status != 'finished' && ombudsman.id">
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
import Alert from '@/components/shared/Alert'

export default {
    data() {
        return {
            id: this.$route.params.id,
            ombudsman: new Ombudsman(),
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
        addUser(user, type) {
            switch (type) {
                case 'manager':
                    this.ombudsman.managerList.push(user)
                    
                    break;
                
                case 'companion':
                    this.ombudsman.transmissionList.push(user)
                    break;
            }
        },
        removeUser(user, index, type) {
            Alert.YesNo("Tem certeza?", "Você está removendo um responsável. Deseja Continuar?").then( res => {
                if(res) {
                    switch (type) {
                    case 'manager':
                        this.ombudsman.managerList.splice(index, 1)
                        
                        break;
                    
                    case 'companion':
                        this.ombudsman.transmissionList.splice(index, 1)
                        break;
                    }
                    model.removeManager(this.id, user, type)
                }
            })
        },
        getPermission() {
            if(this.permission == 'undefined') {
                model.gotPermission(this.id).then(permission => { this.permission = permission; } )
            } else {
                return this.permission
            }
        },
    },
    computed: {
        gotAdminPermission() {
            return (this.getPermission() != 'MANAGER' && this.getPermission() != 'COMPANION') ? true : false
        }
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'add-users': require('./AddUsers.vue').default,
        'ombudsman-closing': require('./closing/Ombudsman.vue').default,
        'manager-closing': require('./closing/Manager.vue').default,
        'chat': require('@/components/shared/chat').default,
    },
    mounted() {
        this.getPermission()
        getter.getOmbudsmanById(this.id).then(res => { this.ombudsman = res ? new Ombudsman(res) : new Ombudsman() })
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
