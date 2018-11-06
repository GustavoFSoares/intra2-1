<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'sala-treinamento/add'}" tag="button">
            Cadastrar Sala
        </router-link>

        <table v-if="roomsTraining" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Andar</th>
                    <th scope="col">Local</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(roomTraining, index) of roomsTraining" :key="index">
                    <td scope="row">{{ roomTraining.id }}</td>
                    <td>{{ roomTraining.name }}</td>
                    <td>{{ roomTraining.floor }}</td>
                    <td>{{ roomTraining.group.enterprise }}</td>
                    <td>
                        <router-link :to='`sala-treinamento/edit/${roomTraining.id}`'>
                            <icon v-tooltip.top="'Editar'" icon="edit"/> 
                        </router-link>
                        <router-link @click.native="remove(roomTraining.id, index)" to="">
                            <icon v-tooltip.top="'Remover'" class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>   
</template>

<script>
import model, { getter } from "@/model/room-training-model";
import moment from 'moment'
import Alert from "@/components/shared/Alert";

export default {
    data() {
        return {
            title: "Lista de Salas",
            roomsTraining: [],
            moment: moment,
            alert: {
                done: { title: "Treinamento Realizado?", message: "Você está marcando este treinamento como realizado. <BR>Tem certeza que deseja realizar essa ação?" },
                remove: { title: "Tem certeza que deseja excluir?", message: "Você está excluindo um treinamento. <BR>Tem certeza que deseja continuar?" }
            }
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
        }
    },
    mounted() {
        getter.getRoomsTraining().then(res => { this.roomsTraining = res })
        
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

    .modal-header {
        display: block;
    }
</style>

