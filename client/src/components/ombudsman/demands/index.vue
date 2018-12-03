<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'ouvidoria/demandas/add'}" tag="button">
            Cadastrar Demandas
        </router-link>

        <div class="form-group form-row col mt-3">
            <input type="search" class="filter form-control" :disabled="!demands" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Modificado em:</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(demand, index) of searchList" :key="index" v-bind:class="{'table-danger': !demand.active}">
                    <th scope="row">{{ demand.id }}</th>
                    <td>{{ demand.name }}</td>
                    <td>{{ moment(demand.c_modified.date).format('DD/MM/YYYY - hh:mm') }}</td>
                    <td @dblclick="changeStatus(demand)">
                        <icon v-tooltip.top="'Desativar'" class="text-success" icon="check-circle" v-if="demand.active"/>
                        <icon v-tooltip.top="'Ativar'" class="text-danger" icon="times-circle" v-else/>
                    </td>
                    <td>
                        <router-link :to='`demandas/edit/${demand.id}`'>
                            <icon v-tooltip.top="'Editar'" icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(demand.id, index)" to="">
                            <icon v-tooltip.top="'Excluir'" class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>   
</template>

<script>
import { DemandModel, getter } from "@/model/ombudsman-model";
import moment from 'moment'
import Alert from "@/components/shared/Alert";

export default {
    data() {
        return {
            title: "Demandas de Ouvidoria",
            filter: '',
            demands: [],
            moment: moment,
            alert: {
                remove: { message: "Tem certeza que deseja excluir?" }
            },
        }
    },
    methods: { 
        remove(id, index){
            Alert.Confirm(this.alert.remove.message).then(res => {
                if(res){
                    DemandModel.doDeleteDemand(id).then(res => null, err => {
                        this.$route.go() 
                    })
                    this.demands.splice(index, 1)
                }
            })
        },
        changeStatus(demand){
            DemandModel.changeDemandStatus(demand)
        }
        
    },
    mounted() {
        getter.getDemands().then(res => { this.demands = res })
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                let list = ''
                return this.demands.filter(demand => {
                    if( exp.test(demand.name)) {
                        return exp
                    } else if( exp.test(demand.id)) {
                        return exp
                    } else if( exp.test(demand.c_modified)) {
                        return exp
                    } else if( exp.test(moment(demand.c_modified.date).format('DD/MM/YYYY - hh:mm'))) {
                        return exp
                    }
                })
            } else {
                return this.demands
            }
        }
    },
}
</script>

<style scoped>
    table {
        margin-top: 10px;
    }
</style>

