<template>
    <div class="container-fluid">

        <div id="rotines-runner">
            <rotines-runner @insert="loadValues()"/>
        </div>
        <h1 class="mb-3">{{ title }}</h1>

        <div class="form-group form-row col">
            <input type="search" class="filter form-control" :disabled="!rotines" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Origem</th>
                    <th scope="col">Pasta Log</th>
                    <th scope="col">Horário Início</th>
                    <th scope="col">Horário Fim</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(rotine) in searchList" :key="`${rotine.id}${!rotine.timeEnd?1:0}`" v-bind:class="{ 'table-warning' : !rotine.timeEnd }">
                    <th> <icon v-if="!rotine.timeEnd" icon="exclamation"/> </th>
                    <th>{{ rotine.id }}</th>
                    <td>{{ rotine.name }}</td>
                    <td>{{ rotine.from }}</td>
                    <td>{{ rotine.target }}</td>
                    <td>{{ moment(rotine.timeBegin.date).format('DD/MM/YYYY - HH:mm') }}</td>
                    <td>
                        <div v-if="rotine.timeEnd"> {{ moment(rotine.timeEnd.date).format('DD/MM/YYYY - HH:mm') }} </div>
                        <div v-else> Não Finalizada </div>
                    </td>
                    <td>
                        <router-link :to='`rotinas/logs/${rotine.id}`'>
                            <icon v-tooltip.top="'Logs'" class="text-secondary" icon="search"/>
                        </router-link>
                    </td> 
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import model, { getter } from "@/model/rotines-model";
import moment from 'moment'

export default {
    data() {
        return {
            title: "Rotinas Executadas",
            rotines: '',
            filter: "",
            moment: moment,
        }
    },
    methods: {
        loadValues() {
            getter.getRotines().then( res => { this.rotines = res })
        }
    },
    mounted() {
        this.loadValues()
    },
    updated() {
        setTimeout(() => {
            this.loadValues()
        }, 10000);
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                let list = ''
                return this.rotines.filter(rotine => {
                    if( exp.test(rotine.core)) {
                        return exp
                    } else if( exp.test(rotine.id)) {
                        return exp
                    } else if( exp.test(rotine.name)) {
                        return exp
                    } else if( exp.test(rotine.from)) {
                        return exp
                    } else if( exp.test(rotine.target)) {
                        return exp
                    } else if( exp.test(moment(rotine.timeBegin.date).format('DD/MM/YYYY - HH:mm'))) {
                        return exp
                    } else if( exp.test(moment(rotine.timeEnd.date).format('DD/MM/YYYY - HH:mm'))) {
                        return exp
                    }
                })
            } else {
                return this.rotines
            }
        }
    },
    components: {
        'rotines-runner': require('./RotinesRunner.vue').default
    }
}
</script>

<style lang="scss" scoped>
    #rotines-runner {
        margin-top: 10px;
    }
</style>