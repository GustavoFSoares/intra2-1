<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'ouvidoria/origem/add'}" tag="button">
            Cadastrar Origem
        </router-link>

        <div class="form-group form-row col mt-3">
            <input type="search" class="filter form-control" :disabled="!origins" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Modificado em:</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(origin, index) of searchList" :key="index">
                    <th scope="row">{{ origin.id }}</th>
                    <td>{{ origin.name }}</td>
                    <td>{{ moment(origin.c_modified.date).format('DD/MM/YYYY - HH:mm') }}</td>
                    <td>
                        <router-link :to='`origem/edit/${origin.id}`'>
                            <icon v-tooltip.top="'Editar'" icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(origin.id, index)" to="">
                            <icon v-tooltip.top="'Excluir'" class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>   
</template>

<script>
import { OriginModel, getter } from "@/model/ombudsman-model";
import moment from 'moment'
import Alert from "@/components/shared/Alert";

export default {
    data() {
        return {
            title: "Origem de Ouvidoria",
            filter: '',
            origins: [],
            moment: moment,
            alert: {
                remove: { message: "Tem certeza que deseja Excluir?" }
            },
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
        
    },
    mounted() {
        getter.getOrigins().then(res => { this.origins = res })
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
                    } else if( exp.test(origin.c_modified)) {
                        return exp
                    } else if( exp.test(moment(origin.c_modified.date).format('DD/MM/YYYY - HH:mm'))) {
                        return exp
                    }
                })
            } else {
                return this.origins
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

