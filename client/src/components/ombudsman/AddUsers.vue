<template>
    <section>
        
        <div  class="mb-3">
            <row label='Selecione novo Usuário'>
                
                <row>
                    <h4>Tipo do Usuário:</h4>
                    <div class="row">
                        <div class="col-md-2">
                            
                            <label for="manager"> Responsável </label>
                            <input type="radio" value="manager" v-model="type" v-validate data-vv-rules="required" :data-vv-as="'Tipos'" name="type">
                    
                        </div>
                        <div class="col-md">

                            <label for="companion"> Acompanhante </label>
                            <input type="radio" value="companion" v-model="type" v-validate data-vv-rules="required" :data-vv-as="'Tipos'" name="type">

                        </div>
                    </div>
                    <require-text :error="errors.has('type')" :text="errors.first('type')"/>
                </row>

                <v-select label="name" :options="(users)" v-model="managerSelected"/>
                <div class='container row mt-3' v-if="managerSelected">
                    <rows class="col-md-7">
                        <visit-card :user="managerSelected"/>
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

    <hr>
    </section>
</template>

<script>
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form";
import UserVisitCard from "@/components/shared/UserVisitcard.vue";
import model from "@/model/ombudsman-model";
const UserModel = require("@/model/user-model").getter;

export default {
    data() {
        return {
            id: this.$route.params.id,
            managerSelected: '',
            users: [],
            sending: false,
            type: '',
        }
    },
    props: {
        "manager_list": { default: [] },
        "tranmission_list": { default: [] },
    },
    methods: {
        isValidForm() { return this.$validator.validateAll().then(success => success)},
        selectManager() {
            this.isValidForm().then(res => {
                if(res) {

                    this.sending = true
                    model.addManager(this.id, this.managerSelected, this.type).then(res => {
                        this.sending = false
                        
                        this.$emit('sendUser', this.managerSelected, this.type)
                        this.managerSelected = ''
                    }).catch(err => {
                        this.sending = false
                    })

                }
            })
        }
    },
    mounted() {
        UserModel.getUsersAdmin().then(res => this.users = res)
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'v-select': VueSelect,
        'require-text': Require,
        'visit-card': UserVisitCard,
    }
}
</script>

<style scoped>
    #user-correct {
        margin-top: 10%
    }
</style>