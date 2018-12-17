<template>
    <div class="container-fluid">
        <div class="row">
            
            <rows> </rows>
            
            <rows>
                <h1>{{ title }}</h1>

                <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'ouvidoria/add'}" tag="button" v-if="gotPermission">
                    Cadastrar Ouvidoria
                </router-link>
            </rows>

            <rows>
                <printer ref="printer" v-if="gotPermission"/>
            </rows>

        </div>

        <div class="form-group form-row col mt-3">
            <input type="search" class="filter form-control" :disabled="!origins" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <!-- <th scope="col">Origem</th> -->
                    <th scope="col">Tipo</th>
                    <th scope="col">Local</th>
                    <th scope="col">Ouvidor</th>
                    <!-- <th scope="col">Paciente</th> -->
                    <th scope="col">Demandas</th>
                    <th scope="col">Relevância</th>
                    <th scope="col">Relatado por:</th>
                    <th scope="col">Registrado em:</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(ombudsman, index) of searchList" :key="index" v-bind:class="getClassTable(ombudsman.status)">
                    <th scope="row">{{ ombudsman.id }}</th>
                    <!-- <td>{{ ombudsman.origin.id }}</td> -->
                    <td>{{ ombudsman.type }}</td>
                    <td v-if="ombudsman.origin.id == 'AMB'">
                        {{ ombudsman.group.name }}
                    </td>
                    <td v-else-if="ombudsman.origin.id == 'INT'">
                        {{ ombudsman.bed }}
                    </td>
                    <td>{{ ombudsman.ombudsman.name.substr(0, 15) }}...</td>
                    <!-- <td>{{ ombudsman.ombudsmanUser.patientName.toUpperCase().substr(0, 15) }}</td> -->
                    <td>
                        <div v-for="demand in ombudsman.demands" :key="demand.id">
                            <div class="demands"><icon icon="angle-double-right"/><i>{{ demand.name }}</i></div>
                        </div>
                    </td>
                    <td>{{ ombudsman.relevance }}</td>                    
                    <td>{{ ombudsman.reportedBy }}</td>                    
                    <td>{{ moment(ombudsman.registerTime.date).format('DD/MM/YYYY - HH:mm') }}</td>
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
            filter: '',
            origins: [],
            moment: moment,
            alert: {
                remove: { message: "Tem certeza que deseja Excluir?" }
            },
            teste: false,
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
                    this.origins.splice(index, 1)
                }
            })
        },
        openPrinter() {
            this.$refs.printer.openModal();
        },
        getClassTable(status) {
            switch (status) {
                case 'finished':
                    return 'table-disabled'     
                    break;
            
                case 'waiting-manager':
                    return 'table-info'     
                    break;
            
                case 'table-warning':
                    return 'manager-received'     
                    break;
            
                default:
                    return ''
                    break;
            }
        }
    },
    mounted() {
        getter.getOmbudsmansReported().then(res => { this.origins = res; })
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                let list = ''
                return this.origins.filter(origin => {
                    if( exp.test(origin.name)) {
                        return exp
                    } else if( exp.test(origin.id)) {
                        return exp
                    } else if( exp.test(origin.registerTime)) {
                        return exp
                    } else if( exp.test(moment(origin.registerTime.date).format('DD/MM/YYYY - HH:mm'))) {
                        return exp
                    }
                })
            } else {
                return this.origins
            }
        },
        gotPermission() {
            if(this.permission == 'undefined') {
                model.gotPermission().then(permission => { this.permission = permission; console.log(permission)} )
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

<style scoped>
    table {
        margin-top: 10px;
    }

    #printer {
        text-align: right;
    }

    .demands {
        text-align: left
    }

    .table-disabled {
        cursor: default;
        text-decoration: none;
        color: #8a8a8a9c;
    }
</style>

