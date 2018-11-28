<template>
    <div class="container-fluid">
        <div class="row">
            
            <rows> </rows>
            
            <rows>
                <h1>{{ title }}</h1>

                <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'ouvidoria/add'}" tag="button">
                    Cadastrar Ouvidoria
                </router-link>
            </rows>

            <rows label="<b>Imprimir Ouvidoria</b>" @click.native="openPrinter()">
                <printer ref="printer"/>
            </rows>

        </div>

        <div class="form-group form-row col mt-3">
            <input type="search" class="filter form-control" :disabled="!origins" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Origem</th>
                    <th scope="col">Tipo</th>
                        <th scope="col">Setor Responsável</th>
                        <th scope="col">Leito</th>
                    <th scope="col">Ouvidor</th>
                    <th scope="col">Paciente</th>
                    <th scope="col">Modificado em:</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(ombudsman, index) of searchList" :key="index">
                    <th scope="row">{{ ombudsman.id }}</th>
                    <td>{{ ombudsman.origin.name }}</td>
                    <td>{{ ombudsman.type }}</td>
                        <td>{{ ombudsman.group.name }}</td>
                        <td>{{ ombudsman.bed }}</td>
                    <td>{{ ombudsman.ombudsman.name }}</td>
                    <td>{{ ombudsman.ombudsmanUser }}</td>
                    <td>{{ moment(ombudsman.registerTime.date).format('DD/MM/YYYY - HH:mm') }}</td>
                    <td>
                        <router-link :to='`tipos/edit/${ombudsman.id}`'>
                            <icon v-tooltip.top="'Editar'" icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(ombudsman.id, index)" to="">
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
import { OriginModel, getter } from "@/model/ombudsman-model";
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
            teste: false
        }
    },
    methods: { 
        remove(id, index){
            Alert.Confirm(this.alert.remove.message).then(res => {
                if(res){
                    OriginModel.doDeleteOrigin(id).then(res => {
                        this.$alert.success(`Tipo <b>#${id}</b> excluído`)
                        }, err => {
                        this.$alert.danger("Tipo não excluído")
                        this.$router.go()
                    })
                    this.origins.splice(index, 1)
                }
            })
        },
        openPrinter() {
            this.$refs.printer.openModal();
        }
        
    },
    mounted() {
        getter.getOmbudsmansReported().then(res => { this.origins = res; console.log(res[0]) })
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
        }
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
        /* 
        display: block;
        position: fixed;

        margin-right: 15%; 
        */
        text-align: right;
    }

    .row {
        /* display: inline-flex; */
    }
</style>

