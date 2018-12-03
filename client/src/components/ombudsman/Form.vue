<template>
    <div class="container">
        <h1>{{ title }}</h1>

        <div class="row">
            <div id="navigation" class="col-md-2 order-md-1 mb-4">
                    
                <div id="form">
                    <h5>Navegação</h5>
                    <ul class="list-group" v-scroll-spy-active="{class: 'watched'}" v-scroll-spy-link>
                        <router-link class="list-group-item" to="" v-for="section in sections" :key="section.id">
                            {{ section.label }}
                        </router-link>
                    </ul>
                </div>
            </div>
            
            <div id="content" class="col-md order-md-2">
                <div data-target="#form" v-scroll-spy>
                                    
                    <section :id="sections.code.id">
                        <row :label="sections.code.label">
                            <v-select v-model="ombudsmanId" name="Ombudsman-Id" :data-vv-as="sections.code.label" v-validate data-vv-rules="required" label="id" :options="values.ombudsmans" @input="loadOmbudsman()"/>
                            <require-text :error="errors.has('Ombudsman-Id')" :text="errors.first('Ombudsman-Id')"/>
                        </row>
                    </section>

                    <section :id="sections.userInformations.id" class="mb-3">
                        <div id="user-informations-title">
                            <h4 class="title">{{ sections.userInformations.label }}</h4>
                        </div>
                        
                        <div id="user-informations-person" class="card border-secondary mb-2">
                            <div class="card-body">
                                
                                <div>
                                    <h5 class="subtitle">{{subtitles.personData.title}}:</h5>
                                </div>
                                <hr>

                                <div class='row'>
                                    <rows :label="subtitles.personData.name" class="col-md-7">
                                        <input type="text" name="Ombudsman-ombudsmanUser-patientName" v-validate data-vv-rules="required" :data-vv-as="subtitles.personData.name" class="form-control" v-model="ombudsman.ombudsmanUser.patientName">
                                        <require-text :error="errors.has('Ombudsman-ombudsmanUser-patientName')" :text="errors.first('Ombudsman-ombudsmanUser-patientName')"/>
                                    </rows>

                                    <rows :label="subtitles.personData.birthday">
                                        <input type="text" name="Ombudsman-ombudsmanUser-birthday" v-validate data-vv-rules="required" :data-vv-as="subtitles.personData.birthday" class="form-control" v-mask="'##/##/####'" v-model="ombudsman.ombudsmanUser.birthday">
                                        <require-text :error="errors.has('Ombudsman-ombudsmanUser-birthday')" :text="errors.first('Ombudsman-ombudsmanUser-birthday')"/>
                                    </rows>
                                    
                                    <rows :label="subtitles.personData.phoneNumber">
                                        <input type="text" name="Ombudsman-ombudsmanUser-phoneNumber" v-validate data-vv-rules="required" :data-vv-as="subtitles.personData.phoneNumber" v-mask="['(##) #####-####', '(##) ####-####']"  class="form-control" v-model="ombudsman.ombudsmanUser.phoneNumber">
                                        <require-text :error="errors.has('Ombudsman-ombudsmanUser-phoneNumber')" :text="errors.first('Ombudsman-ombudsmanUser-phoneNumber')"/>
                                    </rows>
                                </div>

                                <div class='row'>
                                    <rows :label="subtitles.personData.reporterName">
                                        <input type="text" name="Ombudsman-ombudsmanUser-reporterName" v-validate data-vv-rules="required" :data-vv-as="subtitles.personData.reporterName" class="form-control" v-model="ombudsman.ombudsmanUser.declarantName">
                                        <require-text :error="errors.has('Ombudsman-ombudsmanUser-reporterName')" :text="errors.first('Ombudsman-ombudsmanUser-reporterName')"/>
                                    </rows>

                                    <rows :label="subtitles.personData.reporterEmail">
                                        <input type="text" name="Ombudsman-ombudsmanUser-reporterEmail" v-validate data-vv-rules="required|email" :data-vv-as="subtitles.personData.reporterEmail" class="form-control" v-model="ombudsman.ombudsmanUser.email">
                                        <require-text :error="errors.has('Ombudsman-ombudsmanUser-reporterEmail')" :text="errors.first('Ombudsman-ombudsmanUser-reporterEmail')"/>
                                    </rows>
                                </div>

                            </div>
                        </div>

                        <div id="user-information-address" class="card border-secondary">
                            <div class="card-body">

                                <div>
                                    <h5 class="subtitle">{{subtitles.address.title}}</h5>
                                </div>
                                <hr>

                                <div class='row'>
                                    <rows :label="subtitles.address.street" class="col-md-3">
                                        <input type="text" name="Ombudsman-address-street" v-validate data-vv-rules="required" :data-vv-as="subtitles.address.street" class="form-control" v-model="address.street">
                                        <require-text :error="errors.has('Ombudsman-address-street')" :text="errors.first('Ombudsman-address-street')"/>
                                    </rows>
                                    
                                    <rows :label="subtitles.address.number" class="col-md-2">
                                        <input type="text" name="Ombudsman-address-number" v-validate data-vv-rules="required|numeric" :data-vv-as="subtitles.address.number" class="form-control" v-model="address.number">
                                        <require-text :error="errors.has('Ombudsman-address-number')" :text="errors.first('Ombudsman-address-number')"/>
                                    </rows>

                                    <rows :label="subtitles.address.neighborhood" class="col-md-3">
                                        <input type="text" name="Ombudsman-address-neighborhood" v-validate data-vv-rules="required" :data-vv-as="subtitles.address.neighborhood" class="form-control" v-model="address.neighborhood">
                                        <require-text :error="errors.has('Ombudsman-address-neighborhood')" :text="errors.first('Ombudsman-address-neighborhood')"/>
                                    </rows>

                                    <rows :label="subtitles.address.city">
                                        <input type="text" name="Ombudsman-address-city" v-validate data-vv-rules="required" :data-vv-as="subtitles.address.city" class="form-control" v-model="address.city">
                                        <require-text :error="errors.has('Ombudsman-address-city')" :text="errors.first('Ombudsman-address-city')"/>
                                    </rows>

                                    <rows :label="subtitles.address.postCode">
                                        <input type="text" v-mask="'#####-###'" class="form-control" v-model="address.postCode">
                                    </rows>
                                </div>

                            </div>
                        </div>
                    </section>

                    <section :id="sections.type.id" class="mb-3">
                        <div class="row">
                            <rows v-for="(type, index) in types" :key="index">
                                <input type="radio" v-validate data-vv-rules="required" :data-vv-as="sections.type.label" :value="type.name" v-model="ombudsman.type" name="Ombudsman-type">
                                <label :for="index">{{ type.name }}</label>
                            </rows>
                        </div>
                        <require-text :error="errors.has('Ombudsman-type')" :text="errors.first('Ombudsman-type')"/>
                    </section>

                    <!-- <section :id="sections.demands.id" class="mb-3">
                        <div>
                            <h4 class="title">{{ sections.demands.label }}</h4>
                        </div>
                        <hr>

                        <row label=''>
                            
                        </row>
                    </section> -->

                    <section :id="sections.report.id" class="mb-3">
                        <div>
                            <h4 class="title">{{ sections.report.label }}</h4>
                        </div>
                        <hr>

                        <div class="card border-secondary mb-2">
                            <div class="card-body">

                                <div id="report-description" class="mb-4">
                                    
                                    <div>
                                        <h5 class="subtitle">{{ subtitles.description.report }}:</h5>
                                    </div>
                                    <hr>

                                    <row>
                                        <textarea name="Ombudsman-description" v-validate data-vv-rules="required" :data-vv-as="'Descrição'" class="form-control" cols="30" rows="4" v-model="ombudsman.report" placeholder="Descrição: "></textarea>
                                        <require-text :error="errors.has('Ombudsman-description')" :text="errors.first('Ombudsman-description')"/>
                                    </row>

                                </div>

                                <div id="report-sugestion">

                                    <div>
                                        <h5 class="subtitle">{{ subtitles.description.sugestion }}:</h5>
                                    </div>
                                    <hr>

                                    <row>
                                        <textarea name="Ombudsman-sugestion" v-validate data-vv-rules="required" :data-vv-as="subtitles.description.sugestion" class="form-control" cols="30" rows="4" v-model="ombudsman.sugestion" placeholder="Sugestão: "></textarea>
                                        <require-text :error="errors.has('Ombudsman-sugestion')" :text="errors.first('Ombudsman-sugestion')"/>
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
                                    <h5 class="subtitle">{{ subtitles.ombudsman.report }}:</h5>
                                </div>
                                <hr>

                                <row>
                                    <textarea name="Ombudsman-ombudsman-description" v-validate data-vv-rules="required" :data-vv-as="subtitles.ombudsman.report" class="form-control" cols="30" rows="4" v-model="ombudsman.description" placeholder="Informações do Ouvidor: "></textarea>
                                    <require-text :error="errors.has('Ombudsman-ombudsman-description')" :text="errors.first('Ombudsman-ombudsman-description')"/>
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

        </div>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                    Registrar Ouvidoria
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'ouvidoria'}" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>
    </div>
</template>

<script>
import model, { getter } from '@/model/ombudsman-model'
const ModelUser = require('@/model/user-model').default
const GetterUser = require('@/model/user-model').getter
import Ombudsman from "@/entity/Ombudsman";
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form";

export default {
    data() {
        return {
            id: this.$route.params.id,
            title: "Registro de Ouvidorias",
            ombudsmanId: '',
            ombudsman: new Ombudsman(),
            show: false,
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
                demands: { id: "demands", label: "Demandas"},
            },
            subtitles: {
                personData: { title: "Dados Pessoais", name: "Nome Paciente", birthday: "Data de Nascimento", phoneNumber: "Telefone", reporterName: "Nome Relatante", reporterEmail: "Email", },
                address: { title: "Endereço:", street: "Rua", number: "Nº", neighborhood: "Bairro", city: "Cidade", postCode: "CEP", },
                description: { report: "Descrição: (Relatar o ocorrido)", sugestion: "Sugestão/Solicitação", },
                ombudsman: { report: "Informação complementar do Ouvidor", },
            },
            values: {
                users: [],
                ombudsmans: [],
                demands: [],
            },
        }
    },
    methods: {
        loadValues() {
            getter.getOmbudsmansWaiting().then(res => { this.values.ombudsmans = res; })
            getter.getDemands().then(res => { this.values.demands = res; })
        },
        loadOmbudsman() {
            if(this.ombudsmanId) {
                this.ombudsman.id = this.ombudsmanId.id
                this.ombudsman.origin = { id: this.ombudsmanId.origin }
            }
        },
        isValidForm() {
            this.$validator.validateAll().then(success => success? this.submit():"")
        },
        submit() {

        },
    },
    computed: {
        gotPermission() {
            if(this.permission == 'undefined') {
                model.gotPermission(this.id).then(permission => { this.permission = permission } )
            } else {
                return (this.permission != 'USER' && this.report.id) ? true : false
            }
        },
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
        'v-select': VueSelect,
        'require-text': Require,
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

    #navigation div {
        display: block;
        position: fixed;

        max-width: 12%;
        margin-left: -1%;
    }

    .watched {
        pointer-events:none;
        color:grey;
    }

</style>
