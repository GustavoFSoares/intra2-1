<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'modulos/add'}" tag="button">
            Criar Modulo
        </router-link>
        <router-link class="button btn btn-outline-primary btn-lg" :to="{name: 'modulos/permissoes'}" tag="button">
            Gerenciar Permissões
        </router-link>

        <table v-if="modules" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Nome</th>
                    <th scope="col">Última Modificação</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(module, index) of modules" :key="index">
                    <td scope="row">{{ module.id }}</td>
                    <td> <icon :icon="module.icon"/> </td>
                    <td>{{ module.name }}</td>
                    <td>{{ moment(module.c_modified.date).format('DD/MM/YYYY - hh:mm:ss') }}</td>
                    <td @dblclick="changeStatus(module.id)">
                        <i class="text-success fa fa-check-circle" v-if="!module.c_removed"/>
                        <i class="text-danger fa fa-times-circle" v-else/>
                    </td>
                    <td>
                        <router-link :to='`modulos/edit/${module.id}`'>
                            <i class="fa fa-edit"/>
                        </router-link>
                        <router-link @click.native="remove(module.id)" to="">
                            <i class="text-danger fa fa-trash"></i>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>   
</template>

<script>
import model, { getter } from "@/model/modules-model";
import moment from 'moment'

export default {
    data() {
        return {
            title: "Lista de Módulos",
            modules: [],
            moment: moment,
        }
    },
    methods: { 
        remove(id){
            confirm("Tem certeza que deseja excluir?") ?
                model.doDeleteModule(id).then(res => this.$router.go()):''
        },
        changeStatus(id){
            model.doChangeStatusModule(id).then(res => this.$router.go())
        }
        
    },
    mounted() {
        getter.getModules().then(res => { this.modules = res })
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

