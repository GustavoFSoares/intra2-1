<template>
    <div class="container-fluid">
        
        <h1>{{ title }}</h1>

        <div class="mb-3">
            <div class="btn-group" role="group" aria-label="Basic example">
                <router-link to="" class="btn btn-primary" v-for="(type, index) in enterpriseTypes" :key="index" @click.native="search.type = type">{{ type.name }}</router-link>
                <router-link to="" class="btn btn-primary" @click.native="search.type = {id: '', name: ''}">Todos</router-link>
            </div>
        </div>
        
        <div class="form-group form-row col">
            <input type="search" class="filter form-control" :disabled="!reports" @input="search.filter = $event.target.value" placeholder="Nome:"/>
        </div>

        <h2>{{ typeExibited }}</h2>

        <table v-if="reports" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Evento</th>
                    <th scope="col">Setor do Relato</th>
                    <th scope="col">Setor da Falha</th>
                    <th scope="col">Horário da Falha</th>
                    <th scope="col">Paciente Envolvido</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(report) of searchList" :key="report.id" v-bind:class="{'table-danger': report.c_removed == '1'}">
                    <th>{{ report.id }}</th>
                    <td>{{ report.event.description.substr(0, 40) }}</td>
                    <td>{{ report.reportPlace.name }}</td>
                    <td>{{ report.failedPlace.name }}</td>
                    <td>{{ moment(report.failedTime.date).format('DD/MM/YYYY hh:mm') }}</td>
                    <td>
                        <icon class="text-success" icon="check-circle" v-if="report.patientInvolved"/>
                        <icon class="text-danger" icon="times-circle" v-else/>
                    </td>
                    <td>
                        <router-link :to='`notificacao-de-incidentes/detalhe/${report.id}`'>
                            <icon icon="search"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import model, { getter } from '@/model/incident-reporting-model'
import moment from 'moment'

export default {
    data() {
        return {
            title: 'Lista de Incidentes',
            enterpriseTypes: [{id: 'hu', name:"HU"}, {id: 'hpsc', name: "HPSC"}],
            typeExibited: '',
            reports: [],
            moment: moment,
            search: {
                filter: '',
                type: ''
            },
            types: '',
        }
    },
    methods: {
        loadValues() {
            getter.getIncidents().then(res => {this.reports = res; console.log(res[0]); })
        },
    },
    mounted() {
        this.loadValues()
    },
    computed: {
        searchList() {

            if(this.search.type) {
                this.typeExibited = this.search.type.name
                let type = new RegExp(this.search.type.id.trim(), 'i')
                
                return this.reports.filter(reports => {
                    if( type.test(reports.failedPlace.enterprise)) {
                        return type
                    }
                })

            }
            
            if(this.search.filter) {
                let exp = new RegExp(this.search.filter.trim(), 'i')
                
                return this.reports.filter(reports => {
                    
                    if( exp.test(reports.id)) {
                        return exp
                    } else if( exp.test(reports.event.description)) {
                        return exp
                    } else if( exp.test(reports.failedPlace.name)) {
                        return exp
                    } else if( exp.test(reports.reportPlace.name)) {
                        return exp
                    } else if( exp.test(moment(reports.failedTime.date).format('DD/MM/YYYY'))) {
                        return exp
                    }
                })
            } else {
                return this.reports
            }
        }
    },
}
</script>

<style scoped>

</style>
