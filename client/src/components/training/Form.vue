<template>
    <div class="container" @keyup.enter="isValidForm">
        <h1>{{ title }}</h1>

        <row :label="subtitles.name">
            <row>
                <v-select :data-vv-as="subtitles.name" v-validate data-vv-rules="required" label="name" :options="(values.trainingName)" name="Training-name" v-model="training.name" @input="showAnotherName()"/>
                <require-text :error="errors.has('Training-name')" :text="errors.first('Training-name')" :show="true" :attribute="training.name"/>
            </row>
            
            <row class="container" :label="subtitles.anotherTrain" v-if="show.anotherName">
                <input :data-vv-as="subtitles.anotherTrain" v-validate data-vv-rules="required" type="text" class="form-control" name="Training-anotherName" v-model="training.anotherName">
                <require-text :error="errors.has('Training-anotherName')" :text="errors.first('Training-anotherName')" :show="true" :attribute="training.anotherName"/>
            </row>
        </row>

        <row>
            <div class="row">
                <rows :label="subtitles.user.name" class="col-md-8">
                    <v-select v-model="userSelected" label="name" :options="(users)"/>
                </rows>
                <rows :label="subtitles.user.code">
                    <v-select v-model="userSelected" label="id" :options="(users)"/>
                </rows>
            </div>

            <div>
                <user-card v-if="userSelected" :user="userSelected" icon="add" @added="addUser(userSelected)"/>
            </div>
        </row>

        <row>
            <div>
                <button class="btn btn-secondary" data-toggle="collapse" data-target="#showUsers" aria-expanded="true" aria-controls="showUsers">
                    Exibir Lista
                </button>
            </div>

            <div class="container collapse" id="showUsers">
                <div class="list-group">
                    
                    <div class="row">
                        <user-card v-for="(user, index) in training.users" icon="remove" @removed="removeUser(user, index)" :user="user" :key="index"/>
                    </div>

                </div>
            </div>
        </row>
        
        <div class="row">
            <rows :label="subtitles.type">
                <v-select :data-vv-as="subtitles.type" v-validate data-vv-rules="required" label="name" :options="(values.type)" name="Training-type" v-model="training.type" @input="showInstitutionalTypes()"/>
                <require-text :error="errors.has('Training-type')" :text="errors.first('Training-type')" :show="true" :attribute="training.instructor"/>
            </rows>

            <rows>
                <div v-if="show.institutionals">
                    <label>{{ subtitles.institutional }}</label>
                    <v-select :data-vv-as="subtitles.institutional" v-validate data-vv-rules="required" label="name" :options="(values.institutionalTypes)" name="Training-institutional-type" v-model="training.institutionalTypes"/>
                    <require-text :error="errors.has('Training-institutional-type')" :text="errors.first('Training-institutional-type')" :show="true" :attribute="training.institutionalTypes"/>
                </div>
            </rows>
        </div>
        
        <row :label="subtitles.instructor" class="line">
            <v-select :data-vv-as="subtitles.institutional" v-validate data-vv-rules="required" label="name" :options="(users)" name="Training-instructor" v-model="training.instructor"/>
            <require-text :error="errors.has('Training-instructor')" :text="errors.first('Training-instructor')" :show="true" :attribute="training.instructor"/>
        </row>

        <div class="row">
            <rows :label="subtitles.date">
                <label class="float-right"><b>+ Dias 
                    </b><input type="checkbox" v-model="show.multiple">
                </label>
                <date-picker id="begin-time" :multiple="show.multiple">
                    <input v-mask="'##/##/#### - ##:##'" type="text" class="form-control" id="begin-time"/>
                </date-picker>
            </rows>

            <rows :label="subtitles.workload">
                <input :data-vv-as="subtitles.workload" v-validate data-vv-rules="required|numeric" type="number" class="form-control" name="Training-workload" v-model="training.workload">
                <require-text :error="errors.has('Training-workload')" :text="errors.first('Training-workload')" :show="true" :attribute="training.workload"/>
            </rows>

            <rows :label="subtitles.place">
                <v-select :data-vv-as="subtitles.place" v-validate data-vv-rules="required" label="enterprise" :options="(values.places)" name="Training-place" v-model="training.place"/>
                <require-text :error="errors.has('Training-place')" :text="errors.first('Training-place')" :show="true" :attribute="training.place"/>
            </rows>
        </div>

        <div id="buttons">
            <row>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="isValidForm">
                    Cadastrar Treinamento
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'hht'}" tag="button">
                    Voltar
                </router-link>
            </row>
        </div>

    </div>
</template>

<script>
import { FormRw, FormRws, Require, VueSelect } from "@/components/shared/Form";
import DatePicker from "@/components/shared/Form/DatePicker.vue"
import usersExample from './users.json';
import UserCard from './UserCard.vue';
import { getter } from "@/model/training-model";

export default {
    data(){
        return {
            id: '',
            title: "Cadastro de Treinamento",
            users: [],
            userSelected: '',
            training: {
                users: [],
                type: ''
            },
            subtitles: {
                name: "Nome Treinamento",
                user: { name: "Nome do Usuário", code: "Matrícula", },
                anotherTrain: "Outro Treinamento",
                type: "Tipo",
                institutional: "Institucionais",
                instructor: "Multiplicador",
                date: "Horário do Treinamento",
                workload: "Carga Horária",
                place: "Local"
            },
            values: {
                type: [ {id: "institutional", name: "Institucional"}, {id: "extern", name: "Treinamento Externo"}, ],
                institutionalTypes: [ {id: "quality", name: "Qualidade"}, {id: "humanity", name: "Humanização"}, {id: "economy", name: "Econômico Financeiro"}, ],
                places: [],
                trainingName: [ {name: "Padrões de Atendimento"}, {name: "Noções Básicas de Combate a Incêndio"}, {name: "Coleta de Material Biológico"}, {name: "Segurança e Saúde no Trabalho em Hospitais NR32"}, {name: "Política Nacional de Humanização"}, {name: "Suporte Básico de Vida"}, {name: "NR 06"}, {name: "Prevenção e Cuidados com Vírus Respiratórios"}, {name: "Gestão do Ponto"}, {name: "Outros"}, ]
            },
            show: {
                multiple: false,
                institutionals: false,
                anotherName: false,
            }
        }
    },
    methods: {
        addUser(user) {
            this.training.users.push(user)
            let id = this.users.indexOf(user)
            
            this.userSelected = ''
            this.users.splice(id, 1)
        },
        removeUser(user, index) {
            this.training.users.splice(index, 1)
            this.users.push(user)
        },
        isValidForm() {
            this.$validator.validateAll().then(success => success ? this.submit():"")
        },
        submit() {
            
        },
        loadValues() {
            // this.users = usersExample
            getter.getEnterprises().then(res => this.values.places = res)
            getter.getUsers().then(res => this.users = res)
        },
        showInstitutionalTypes() {
            this.show.institutionals = this.training.type.id == "institutional" ? true : false
        },
    },
    components: {
        'row': FormRw,
        'rows': FormRws,
        'require-text': Require,
        'v-select': VueSelect,
        'user-card': UserCard,
        'date-picker': DatePicker,
    },
    mounted() {
        this.loadValues()
    }
}
</script>

<style scoped>
    #buttons {
        margin-top: 5%;
    }

    .line {
        margin-top: 15px;
    }

    .row {
        margin-top: 15px;
    }
</style>
