<template>
    <div class="container-fluid">
        <div>
            <div class="ombudsman-header">
                <h1>{{ title }}</h1>

                <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'ouvidoria/add'}" tag="button" v-if="gotPermission">
                    Cadastrar Ouvidoria
                </router-link>
            </div>
        </div>

        <div class="ombudsman-funcions row">
            
            <rows class="filters">
                <div class="buttons">

                    <div class="status-buttons row">
                        <button class="status-button button btn btn-outline-danger btn-lg mb-3" v-bind:class="{ 'active': filter.relevance=='URGENTE' }" @click="filteringRelevance('URGENTE')">
                            Urgente <icon icon="angry"/>
                        </button>
                        <button class="status-button button btn btn-outline-warning btn-lg mb-3" v-bind:class="{ 'active': filter.relevance=='ALTA' }" @click="filteringRelevance('ALTA')">
                            Alta <icon icon="tired"/>
                        </button>
                        <button class="status-button button btn btn-outline-success btn-lg mb-3" v-bind:class="{ 'active': filter.relevance=='MÉDIA' }" @click="filteringRelevance('MÉDIA')">
                            Média <icon icon="meh"/>
                        </button>
                        <button class="status-button button btn btn-outline-info btn-lg mb-3" v-bind:class="{ 'active': filter.relevance=='BAIXA' }" @click="filteringRelevance('BAIXA')">
                            Baixa <icon icon="laugh"/>
                        </button>
                    </div>

                    <hr>
                    <div class="state-buttons row mb-3">
                        <button class="state-button button btn btn-outline-clean btn-lg" v-bind:class="{ 'active': filter.status=='REGISTERED' }" @click="filter.status = 'REGISTERED'">
                            Registrado <icon icon="file-archive"/>
                        </button>
                        <button class="state-button button btn btn-outline-clean btn-lg" v-bind:class="{ 'active': filter.status=='WAITING-MANAGER' }" @click="filter.status = 'WAITING-MANAGER'">
                            Enviado <icon icon="file-archive"/>
                        </button>
                        <button class="state-button button btn btn-outline-clean btn-lg" v-bind:class="{ 'active': filter.status=='CLOSED' }" @click="filter.status = 'CLOSED'">
                            Finalizado <icon icon="file-archive"/>
                        </button>
                        <button class="state-button button btn btn-outline-clean btn-lg" v-bind:class="{ 'active': filter.status=='FINISHED' }" @click="filter.status = 'FINISHED'">
                            Arquivado <icon icon="file-archive"/>
                        </button>
                    </div>

                </div>
            </rows>
            
            <rows class="printer">
                <printer ref="printer" v-show="gotPermission"/>
            </rows>

        </div>

        <div class="form-group form-row col mt-3">
            <input type="search" class="filter form-control" :disabled="!ombudsmans" @input="filter.text = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Local</th>
                    <th scope="col">Ouvidor</th>
                    <th scope="col">Demandas</th>
                    <th scope="col">Relatado por:</th>
                    <th scope="col">Relevância:</th>
                    <th scope="col">Registrado em:</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(ombudsman, index) of searchList" :key="index" v-bind:class="getClassTable(ombudsman.relevance, ombudsman.status)">
                    <th scope="row">{{ ombudsman.id }}</th>
                    <td>{{ ombudsman.type }}</td>
                    <td v-if="ombudsman.origin.id == 'AMB'">
                        {{ ombudsman.group.name }}
                    </td>
                    <td v-else-if="ombudsman.origin.id == 'INT'">
                        Leito {{ ombudsman.bed }}
                    </td>
                    <td>{{ ombudsman.ombudsman.name.substr(0, 15) }}...</td>
                    <td>
                        <div v-for="demand in ombudsman.demands" :key="demand.id">
                            <div class="demands"><icon icon="angle-double-right"/><i>{{ demand.name }}</i></div>
                        </div>
                    </td>
                    <td>{{ ombudsman.reportedBy }}</td>                    
                    <td>{{ ombudsman.relevance.toUpperCase() }}</td>                    
                    <td>{{ ombudsman.registerTime.date | humanizeDate }}</td>
                    <td>
                        <router-link :to='`ouvidoria/detalhe/${ombudsman.id}`'>
                            <icon v-tooltip.top="'Detalhe'" class="text-warning" icon="search"/>
                        </router-link>
                        <router-link :to='`ouvidoria/edit/${ombudsman.id}`' v-if="ombudsman.status=='registered' && gotPermission">
                            <icon v-tooltip.top="'Editar'" icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(ombudsman.id, index)" to=""  v-if="ombudsman.status=='registered' && gotPermission">
                            <icon v-tooltip.top="'Excluir'" class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
                <tr v-if="searchList.length == 0 && loaded">
                    <td class="bold text-disabled" colspan="50"> Nenhum registro encontrado </td>
                </tr>

                
            </tbody>
        </table>
    </div>   
</template>

<script>
import { FormRw, FormRws, VueSelect } from "@/components/shared/Form";
import Alert from '@/components/shared/Alert'
import model, { getter } from "@/model/ombudsman-model";
import moment from 'moment'

export default {
    data() {
        return {
            title: "Ouvidorias",
            filter: {
                text: '',
                status: 'WAITING-MANAGER',
                relevance: '',
            },
            ombudsmans: [],
            moment: moment,
            alert: {
                remove: { message: "Tem certeza que deseja Excluir?" }
            },
            loaded: false,
            permission: 'undefined',
        }
    },
    methods: { 
        remove(id, index){
            Alert.Confirm(this.alert.remove.message).then(res => {
                if(res){
                    model.doDelete(id).then(res, err => {
                        setTimeout(() => { this.$router.go() }, 3000);
                    })
                    this.ombudsmans.splice(index, 1)
                }
            })
        },
        openPrinter() {
            this.$refs.printer.openModal();
        },
        getClassTable(relevance, status) {
            let tableColor = ''
            switch (relevance.toUpperCase()) {
                case 'URGENTE':
                    tableColor = 'table-danger'
                    break;

                case 'ALTA':
                    tableColor = 'table-warning'
                    break;
            
                case 'MÉDIA':
                    tableColor = 'table-success'
                    break;
            
                case 'baixa':
                    tableColor = 'table-info'
                    break;

                default:
                    return ''
                    break;
            }

            if(status == 'finished') { return 'table-disabled' }

            return tableColor

        },
        filteringRelevance(relevance) {
            if( this.filter.relevance == relevance ) {
                this.filter.relevance = false
            } else {
                this.filter.relevance = relevance
            }
        },
    },
    mounted() {
        getter.getOmbudsmansReported().then(res => { this.ombudsmans = res; this.loaded = true })
    },
    computed: {
        searchList() {
            if(this.filter.text) {
                let exp = new RegExp(this.filter.text.trim(), 'i')
                
                let list = ''
                return this.secondFiler.filter(ombudsman => {
                    if( exp.test(ombudsman.id)) {
                        return exp
                    } else if( exp.test(ombudsman.ombudsman.name)) {
                        return exp
                    } else if( exp.test(ombudsman.group.name)) {
                        return exp
                    } else if( exp.test(ombudsman.bed)) {
                        return exp
                    } else if( exp.test(ombudsman.relevance)) {
                        return exp
                    } else if( exp.test(ombudsman.reportedBy)) {
                        return exp
                    } else if( exp.test(ombudsman.type)) {
                        return exp
                    } else if( exp.test( this.$options.filters.humanizeDate(ombudsman.registerTime.date) ) ) {
                        return exp
                    }
                })
            } else {
                return this.secondFiler
            }
        },
        secondFiler() {
            if(this.ombudsmans.length == 0) {
                return []
            }
            
            let ombudsmans = this.ombudsmans
            if(this.filter.relevance) {
                ombudsmans = ombudsmans.filter(omb => {
                    if(omb.relevance.toUpperCase() == this.filter.relevance) {
                        return omb
                    }
                })
            }
            if(this.filter.status) {
                ombudsmans = ombudsmans.filter(omb => {
                    if(omb.status.toUpperCase() == this.filter.status) {
                        return omb
                    }
                })
            }
            return ombudsmans
        },
        gotPermission() {
            if(this.permission == 'undefined') {
                model.gotPermission().then(permission => { this.permission = permission; } )
            } else {
                return (this.permission != 'USER' && this.permission) ? true : false
            }
        },
    },
    components: {
        'rows': FormRws,
        'printer': require('./Printer.vue').default,
    },
}
</script>

<style lang="scss" scoped>
    table {
        margin-top: 10px;
    }

    .ombudsman-funcions {
        display: flex;
        flex-wrap: wrap;
    }

    .status-buttons, .state-buttons {
        button {
            margin-left: 10px;
        }

        display: flex;
        justify-content: center;
    }

    .demands {
        text-align: left
    }

</style>

