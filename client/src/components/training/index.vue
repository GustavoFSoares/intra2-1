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
                    <th scope="col">Local</th>
                    <th scope="col">Horário Treinamento</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Carga Horária</th>
                    <th scope="col">Realizado</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(training, index) of trainings" :key="index">
                    <td scope="row">{{ training.id }}</td>
                    <td>{{ training.name }}</td>
                    <td>{{ training.enterprise.substr(0, 11) }}</td>
                    <td>
                        <span> {{ moment(training.beginTime.date).format('DD/MM/YYYY') }} - 
                            <span><b>{{ moment(training.beginTime.date).format('HH:mm') }}</b></span>
                            até <span><b>{{ moment(training.endTime.date).format('HH:mm') }}</b></span>
                        </span>
                    </td>
                    <td>{{ training.type }}</td>
                    <td>{{ getWorkload(training.workload) }} horas</td>
                    <td> <input type="checkbox" @change="isDone(training)" :disabled="training.done ? true : false" v-model="training.done"/></td>
                    <td>
                        <router-link :to='`hora-homem-treinamento/lista-participantes/${training.id}`'>
                            <icon v-tooltip.top="'Lista de Participantes'" class="text-success" icon="user-plus"/>
                        </router-link>
                        <router-link :to='`hora-homem-treinamento/edit/${training.id}`' v-if="!training.done">
                            <icon v-tooltip.top="'Editar'" icon="edit"/> 
                        </router-link>
                        <router-link @click.native="remove(training.id, index)" to="" v-if="!training.done">
                            <icon v-tooltip.top="'Remover'" class="text-danger" icon="trash-alt"/>
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
import Alert from "@/components/shared/Alert";

export default {
    data() {
        return {
            title: "Lista de Treinamentos",
            trainings: [],
            moment: moment,
            alert: {
                done: { title: "Terminando o treinamento?", message: "Você está marcando este treinamento como realizado."+
                    "<BR>Ao fazer isso, você será incapaz de <b>editar</b> o treinamento e <b>Adicionar outros participantes</b>"+
                    "<BR>Tem certeza que deseja realizar essa ação?" },
                remove: { title: "Tem certeza que deseja excluir?", message: "Você está excluindo um treinamento. <BR>Tem certeza que deseja continuar?" }
            },
        }
    },
    methods: { 
        remove(id, index){
            Alert.Confirm(this.alert.remove.message).then(res => {
                if(res){
                    model.doDelete(id)
                    this.trainings.splice(index, 1)
                }
            })
        },
        isDone(training) {
            Alert.YesNo(this.alert.done.title, this.alert.done.message).then(res => {
                if(res){
                    model.isDone(training.id)
                } else {
                    training.done = false
                }}
            )
        },
        getWorkload(workload) {
            workload = model.getWorkloadObject(workload)
            return `${workload.hour}:${workload.minute}`
        },
    },
    mounted() {
        getter.getTrainings().then(res => { this.trainings = res })
    },
}
</script>

<style lang="scss" scoped>
    .space {
        margin-top: 3%;
    }

    .classe {
        color: #575757d3;
    }

    table {
        margin-top: 10px;
    }

    .modal-header {
        display: block;
    }
</style>

