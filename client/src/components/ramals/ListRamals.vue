<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <div class="form-group form-row col">
            <input type="search" class="filter form-control" :disabled="!ramals" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">Ramal</th>
                <th scope="col">Setor</th>
                <th scope="col">Núcleo</th>
                <th scope="col">Unidade</th>
                <th scope="col">Andar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(ramal) in searchList" :key="ramal.id">
                    <th>{{ ramal.number }}</th>
                    <td>{{ ramal.group.name }}</td>
                    <!-- <td>{{ ramal.core.toUpperCase() }}</td> -->
                    <td>{{ ramal.core }}</td>
                    <td>{{ ramal.group.enterprise }}</td>
                    <td>{{ ramal.floor }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { getter } from "@/model/ramal-model";
export default {
    data() {
        return {
            title: "Lista de Ramais",
            ramals: "",
            filter: "",
        }
    },
    mounted() {
            getter.getRamals().then( res => { this.ramals = res })
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                let list = ''
                return this.ramals.filter(ramals => {
                    if( exp.test(ramals.group.name)) {
                        return exp
                    } else if( exp.test(ramals.core)) {
                        return exp
                    } else if( exp.test(ramals.number)) {
                        return exp
                    } else if( exp.test(ramals.group.enterprise)) {
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