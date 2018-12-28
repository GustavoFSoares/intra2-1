<template>
    <div>
        
        <section>
            <div class="card border-secondary">
                <div class="card-body">

                    <div v-if="!ombudsman.managerResponse"  class="mb-3">
                        <p v-if="!ombudsman.manager" class="text-danger"><b>Necessário adicionar Responsável!</b></p>
                        <row label='Selecione novo Responsável'>
                            <v-select label="name" :options="(values.users)" v-model="userSelected"/>
                            
                            <div class='container row mt-3' v-if="userSelected">
                                <rows class="col-md-7">
                                    <visit-card :user="userSelected"/>
                                </rows>

                                <rows>
                                    <div id="user-correct">
                                        <p>Responsável Correto?</p>
                                        <button class="btn btn-outline-primary" @click="selectManager()" :disabled="sending">Selecionar Responsável</button>
                                    </div>
                                </rows>
                            </div>

                        </row>
                    </div>


                    <div id="manager-added" v-if="ombudsman.manager">

                        <div id="manager-response">
                            <row v-if="ombudsman.managerResponse">

                                <h6 class="card-subtitle mb-2 text-muted">Resposta ao Responsável:</h6>
                                <p class="card-text">
                                    {{ ombudsman.managerResponse }}
                                </p>
                            </row>
                            
                            <div v-else>
                                <p class="text-danger"><b>Aguardando resposta do Responsável</b></p>
                            </div>
                        </div>

                        <blockquote class="blockquote pull-right signature">
                            <footer class="blockquote-footer">Responsável Responsável: 
                                <cite v-if="ombudsman.manager" title="Source Title"><b>{{ ombudsman.manager.name }}</b></cite>
                            </footer>
                        </blockquote>
                    </div>
                     <div v-else-if="ombudsman.responseToUser">
                        <p class="text-danger"><b>Finalizado sem resposta do Responsável da Área</b></p>
                    </div>

                </div>
            </div>
        </section>
            
        <section class="mt-3">
            <div class="card border-secondary">
                <div class="card-body">

                    <row v-if="ombudsman.responseToUser">
                        <h6 class="card-subtitle mb-2 text-muted">Resposta Enviada ao Paciente:</h6>
                        <p class="card-text">
                            {{ ombudsman.responseToUser }}
                        </p>
                    </row>
                    <row v-else>
                        <div>
                            <h5 class="subtitle text-left">Resposta ao Paciente:</h5>
                        </div>
                        <textarea name="Ombudsman-ombudsman-description" class="form-control" cols="30" rows="4" v-model="responseToUser" placeholder="Resposta do Responsável Responsável: "></textarea>
                    </row>
                                        
                </div>
                                
                <blockquote class="blockquote pull-right signature">
                    <footer class="blockquote-footer">Ouvidor do Fechamento: 
                        <cite class="text-right" title="Source Title"><b>{{ ombudsmanToResponse.name }}</b></cite>
                    </footer>
                </blockquote>
            </div>
        </section>
            
    </div>
</template>

<script>
import { FormRw, FormRws, VueSelect } from "@/components/shared/Form";
import UserVisitCard from "@/components/shared/UserVisitcard.vue";
import model from "@/model/ombudsman-model";
const UserModel = require("@/model/user-model").getter;

export default {
    data() {
        return {
            sending: false,
            ombudsmanToResponse: '',
            responseToUser: '',
            userSelected: '',
            values: {
                users: []
            }
        }
    },
    props: {
        ombudsman: '',
    },
    methods: {
        submit() {
            return model.setOmbudsmanToResponse(this.ombudsman.id, { 'ombudsman': this.ombudsmanToResponse, 'ombudsmanResponse': this.responseToUser })
        },
        selectManager() {
            this.sending = true
            model.addManager(this.ombudsman.id, this.userSelected).then(res => {
                this.ombudsman.manager = this.userSelected
                this.userSelected = ''
                this.sending = false
            }).catch(err => {
                this.ombudsman.manager = ''
                this.sending = false
            })
        }
    },
    mounted() {
        this.ombudsmanToResponse = this.ombudsman.ombudsmanToResponse ? this.ombudsman.ombudsmanToResponse : this.$session.get('user')
        UserModel.getUsersAdmin().then(res => this.values.users = res)
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'v-select': VueSelect,
        'visit-card': UserVisitCard,
    }
}
</script>

<style scoped>
    #user-correct {
        margin-top: 10%
    }
</style>
