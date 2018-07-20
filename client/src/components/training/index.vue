<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'hht/add'}" tag="button">
            Cadastrar Treinamento
        </router-link>

        <table v-if="trainings" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Multiplicador</th>
                    <th scope="col">Local</th>
                    <th scope="col">Horário de Início</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Carga Horária</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(training, index) of trainings" :key="index">
                    <td scope="row">{{ training.id }}</td>
                    <td>{{ training.name }}</td>
                    <td>{{ training.instructor.name }}</td>
                    <td>{{ training.place }}</td>
                    <td>{{ training.timeTraining }}</td>
                    <td>{{ training.type }}</td>
                    <td>{{ training.workload }} horas</td>
                    <td>
                        <router-link :to='`hora-homem-treinamento/edit/${training.id}`'>
                            <icon icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(training.id, index)" to="">
                            <icon class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>   
</template>

<script>
import model, { getter } from "@/model/training-model";
import moment from 'moment'

export default {
    data() {
        return {
            title: "Lista de Módulos",
            trainings: [],
            moment: moment,
        }
    },
    methods: { 
        remove(id, index){
            if (confirm("Tem certeza que deseja excluir?")) {
                model.doDelete(id)
                this.trainings.splice(index, 1)
            }
        },
    },
    mounted() {
        getter.getTrainings().then(res => { this.trainings = res })
    },
}
</script>

<style scoped>
    .space {
        margin-top: 3%;
    }

    .classe {
        color: #575757d3;
    }

    table {
        margin-top: 10px;
    }
</style>

