<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'documentos-eletronicos/tipo/add'}" tag="button">
            Cadastrar Tipo
        </router-link>

        <div class="form-group form-row col mt-3">
            <input type="search" class="filter form-control" :disabled="!types" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Código</th>
                    <th scope="col">Modificado em:</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(type, index) of searchList" :key="index">
                    <th scope="row">{{ type.id }}</th>
                    <td>{{ type.name }}</td>
                    <td>{{ type.code }}</td>
                    <td>{{ type.c_modified.date | humanizeDate }}</td>
                    <td>
                        <router-link :to='`tipo/edit/${type.id}`'>
                            <icon v-tooltip.top="'Editar'" icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(type.id, index)" to="">
                            <icon v-tooltip.top="'Excluir'" class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>   
</template>

<script>
import { TypeModel, getter } from "@/model/eletronic-documents-model";
import Alert from "@/components/shared/Alert";

export default {
    data() {
        return {
            title: "Tipos de Documentos Eletrônicos",
            filter: '',
            types: [],
            alert: {
                remove: { message: "Tem certeza que deseja Excluir?" }
            },
        }
    },
    methods: { 
        remove(id, index){
            Alert.Confirm(this.alert.remove.message).then(res => {
                if(res){
                    TypeModel.doDeleteType(id).catch(err => {
                        setTimeout(() => {
                            this.$router.go()
                        }, 3000);
                    })
                    this.types.splice(index, 1)
                }
            })
        },
        
    },
    mounted() {
        getter.getTypes().then(res => { this.types = res })
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                let list = ''
                return this.types.filter(type => {
                    if( exp.test(type.name)) {
                        return exp
                    } else if( exp.test(type.id)) {
                        return exp
                    } else if( exp.test(type.code)) {
                        return exp
                    } else if( exp.test( this.$options.filters.humanizeDate(type.c_modified.date) )) {
                        return exp
                    }
                })
            } else {
                return this.types
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

