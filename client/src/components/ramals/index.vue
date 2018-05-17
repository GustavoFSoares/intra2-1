<template>
    <div>
        <h1>{{ title }}</h1>

        <div class="form-group form-row col">
            <input type="search" class="filter form-control" @input="filter = $event.target.value" placeholder="Nome:"/>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">Ramal</th>
                <th scope="col">Descrição</th>
                <th scope="col">Setor</th>
                <th scope="col">Unidade</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(ramal) in searchList" :key="ramal.id">
                    <th scope="row">{{ ramal.number }}</th>
                    <td>{{ ramal.description }}</td>
                    <td>{{ ramal.sector }}</td>
                    <td>{{ ramal.enterprise }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import model from "@/model/ramals";
export default {
    data() {
        return {
            title: "Lista de Ramais",
            ramals: "",
            filter: "",
        }
    },
    mounted() {
            model.getRamals().then( res => { this.ramals = res })
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                let list = ''
                return this.ramals.filter(ramals => {
                    if( exp.test(ramals.description)) {
                        return exp
                    } else if( exp.test(ramals.sector)) {
                        return exp
                    } else if( exp.test(ramals.number)) {
                        return exp
                    } else if( exp.test(ramals.enterprise)) {
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