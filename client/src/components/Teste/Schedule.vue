<template>
    <div class="container">
        <span> <icon icon="clock"/> {{ title }}</span>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Local</th>
                    <th scope="col">Horário</th>
                    <th scope="col">Carga Horária</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(training, index) in trainings" :key="training.id">
                    <td>{{ training.id }}</td>
                    <td>{{ training.name }}</td>
                    <td>{{ training.place }}</td>
                    <td>{{ training.timeTraining }}</td>
                    <td>{{ training.workload }}</td>
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

export default {
    data() {
        return {
            title: "Agenda de Treinamentos",
            trainings: ''
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

<style scoped>
    
</style>

