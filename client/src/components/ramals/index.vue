<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <div class="mb-4">
            <router-link class=" button btn btn-outline-secondary btn-lg" :to="{name: 'ramais/add'}" tag="button">
                Cadastrar Ramal
            </router-link>
        </div>

        <div class="form-group form-row col">
            <input type="search" class="filter form-control" :disabled="!ramals" @input="filter = $event.target.value" placeholder="Nome:"/>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ramal</th>
                    <th scope="col">Setor</th>
                    <th scope="col">Núcleo</th>
                    <th scope="col">Unidade</th>
                    <th scope="col">Andar</th>
                    <th scope="col">Última Atualização</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(ramal) in searchList" :key="ramal.id" v-bind:class="{ 'table-danger' : ramal.c_removed }">
                    <th>{{ ramal.id }}</th>
                    <td>{{ ramal.number }}</td>
                    <td>{{ ramal.group.name }}</td>
                    <td>{{ ramal.core }}</td>
                    <td>{{ ramal.group.enterprise }}</td>
                    <td>{{ ramal.floor }}</td>
                    <td>{{ moment(ramal.c_modified.date).format('DD/MM/YYYY - hh:mm') }}</td>
                    <td @dblclick="unactive(ramal.id)">
                        <icon class="text-success" icon="check-circle" v-if="!ramal.c_removed"/>
                        <icon class="text-danger" icon="times-circle" v-else/>
                    </td>
                    <td>
                        <router-link :to='`ramais/edit/${ramal.id}`'>
                            <icon icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(ramal.id)" to=''>
                            <icon class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import model, { getter } from "@/model/ramal-model";
import moment from 'moment'

export default {
    data() {
        return {
            title: "Lista de Ramais",
            ramals: "",
            filter: "",
            moment: moment,
        }
    },
    methods: {
        remove(id) {
            confirm("Tem certeza que deseja excluir ?") ?
                model.doDelete(id).then(res => this.$router.go()) : ""
        },
        unactive(id) {
            model.doUnactive(id).then(res => this.$router.go())
        }
    },
    mounted() {
        getter.getAllRamals().then( res => { this.ramals = res })
        
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                let list = ''
                return this.ramals.filter(ramals => {
                    if( exp.test(ramals.core)) {
                        return exp
                    } else if( exp.test(ramals.group.name)) {
                        return exp
                    } else if( exp.test(ramals.group.enterprise)) {
                        return exp
                    } else if( exp.test(ramals.number)) {
                        return exp
                    } else if( exp.test(ramals.id)) {
                        return exp
                    } else if( exp.test(ramals.floor)) {
                        return exp
                    }
                })
            } else {
                return this.ramals
            }
        }
    },
}
</script>

<style scoped>
    
</style>