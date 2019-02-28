<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'documentos-eletronicos/status/add'}" tag="button">
            Cadastrar Status
        </router-link>

        <div class="form-group form-row col mt-3">
            <input status="search" class="filter form-control" :disabled="!status" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Level</th>
                    <th scope="col">Modificado em:</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(status, index) of searchList" :key="index">
                    <th scope="row">{{ status.id }}</th>
                    <td>{{ status.name }}</td>
                    <td>{{ Number(status.level) }}</td>
                    <td>{{ status.c_modified.date | humanizeDate }}</td>
                    <td>
                        <router-link :to='`status/edit/${status.id}`'>
                            <icon v-tooltip.top="'Editar'" icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(status.id, index)" to="">
                            <icon v-tooltip.top="'Excluir'" class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>   
</template>

<script>
import { StatusModel, getter } from "@/model/eletronic-documents-model";
import Alert from "@/components/shared/Alert";

export default {
    data() {
        return {
            title: "Status de Documentos Eletrônicos",
            filter: '',
            status: [],
            alert: {
                remove: { message: "Tem certeza que deseja Excluir?" }
            },
        }
    },
    methods: { 
        remove(id, index){
            Alert.Confirm(this.alert.remove.message).then(res => {
                if(res){
                    StatusModel.doDeleteStatus(id).catch(err => {
                        setTimeout(() => {
                            this.$router.go()
                        }, 3000);
                    })
                    this.status.splice(index, 1)
                }
            })
        },
        
    },
    mounted() {
        getter.getStatus().then(res => { this.status = res })
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                let list = ''
                return this.status.filter(status => {
                    if( exp.test(status.name)) {
                        return exp
                    } else if( exp.test(status.id)) {
                        return exp
                    } else if( exp.test(status.level)) {
                        return exp
                    } else if( exp.test( this.$options.filters.humanizeDate(status.c_modified.date) )) {
                        return exp
                    }
                })
            } else {
                return this.status
            }
        }
    },
}
</script>

<style lang="scss" scoped>
    table {
        margin-top: 10px;
    }
</style>

