<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'convenios/add'}" tag="button">
            Cadastrar Convenio
        </router-link>

        <table v-if="covenants" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Link</th>
                    <th scope="col">Última Modificação</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(covenant, index) of covenants" :key="index">
                    <td scope="row">{{ covenant.id }}</td>
                    <td>{{ covenant.title }}</td>
                    <td >{{ covenant.link.substring(0,40) }}</td>
                    <td>{{ moment(covenant.c_modified.date).format('DD/MM/YYYY - hh:mm:ss') }}</td>
                    <td @dblclick="changeStatus(covenant.id)">
                        <i class="text-success fa fa-check-circle" v-if="!covenant.c_removed"/>
                        <i class="text-danger fa fa-times-circle" v-else/>
                    </td>
                    <td>
                        <router-link :to='`convenios/edit/${covenant.id}`'>
                            <i class="fa fa-edit"/>
                        </router-link>
                        <router-link @click.native="remove(covenant.id)" to="">
                            <i class="text-danger fa fa-trash"></i>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>   
</template>

<script>
import model, { getter } from "@/model/covenants-model";
import moment from 'moment'

export default {
    data() {
        return {
            title: "Lista de Módulos",
            covenants: [],
            moment: moment,
        }
    },
    methods: { 
        remove(id){
            confirm("Tem certeza que deseja excluir?") ?
                model.doDeleteCovenant(id).then(res => this.$router.go()):''
        },
        changeStatus(id){
            model.doChangeStatusCovenant(id).then(res => this.$router.go())
        }
        
    },
    mounted() {
        getter.getCovenants().then(res => { this.covenants = res })
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

