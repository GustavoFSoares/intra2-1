<template>
    <div class="container">
        <span> <icon icon="clock"/> {{ title }}</span>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Local</th>
                    <th scope="col">Horário de Início</th>
                    <th scope="col">Horário de Fim</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(training, index) in trainings" :key="training.id" v-bind:class="{'table-danger': moment().diff(training.beginTime.date, 'days') == 0}">
                    <td>{{ training.id }}</td>
                    <td>{{ training.name }}</td>
                    <td>{{ training.enterprise.substr(0, 16) }}</td>
                    <td>{{ moment(training.beginTime.date).format('DD/MM/YYYY - HH:mm') }}</td>
                    <td>{{ moment(training.endTime.date).format('DD/MM/YYYY - HH:mm') }}</td>
                    <td> 
                        <router-link to="" class="text-danger" @click.native="exitTraining(training, index)">
                            <icon id='icon' icon="times-circle"/>   
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import $ from "jquery"
import model, { getter } from "@/model/training-participant-model";
import moment from "moment";

export default {
    data() {
        return {
            title: "Agenda de Treinamentos",
            trainings: '',
            moment: moment,
        }
    },
    mounted() {
        getter.getTrainingsByParticipant(this.$session.get('user').id).then(res => { this.trainings = res })
    },
    methods: {
        exitTraining(training, index) {
            if( confirm("Deseja sair treinamento?") ) {
                model.removeParticipant(this.$session.get('user').id, training.id).then( 
                    this.trainings.splice(index, 1)
                )
            }
        }
    }
}
</script>

<style lang="scss">
    thead {
        background-color: #e3f2fd;
        
    }
</style>
