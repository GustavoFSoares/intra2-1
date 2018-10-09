<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <div class="mb-4">
            <router-link class=" button btn btn-outline-secondary btn-lg" :to="{name: 'ramais/add'}" tag="button">
                Cadastrar Ramal
            </router-link>
        </div>

        <div class="form-group form-row col">
            <input type="search" class="filter form-control" :disabled="!ramals" @input="filter = $event.target.value" placeholder="Nome:"/>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ramal</th>
                    <th scope="col">Setor</th>
                    <th scope="col">Núcleo</th>
                    <th scope="col">Unidade</th>
                    <th scope="col">Andar</th>
                    <th scope="col">Última Atualização</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(ramal, index) in searchList" :key="ramal.id" v-bind:class="{ 'table-danger' : !ramal.active }">
                    <th>{{ ramal.id }}</th>
                    <td>{{ ramal.number }}</td>
                    <td>{{ ramal.group.name }}</td>
                    <td>{{ ramal.core }}</td>
                    <td>{{ ramal.group.enterprise }}</td>
                    <td>{{ ramal.floor }}</td>
                    <td>{{ moment(ramal.c_modified.date).format('DD/MM/YYYY - hh:mm') }}</td>
                    <td @dblclick="unactive(ramal)">
                        <icon class="text-success" icon="check-circle" v-if="ramal.active"/>
                        <icon class="text-danger" icon="times-circle" v-else/>
                    </td>
                    <td>
                        <router-link :to='`ramais/edit/${ramal.id}`'>
                            <icon icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(ramal.id, index)" to=''>
                            <icon class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import model, { getter } from "@/model/ramal-model";
import moment from 'moment'
import Alert from "@/components/shared/Alert";

export default {
    data() {
        return {
            title: "Lista de Ramais",
            ramals: "",
            filter: "",
            moment: moment,
            alert: {
                info: "Houve um erro ao tentar modificar o Ramal. Por favor tente novamente ou contate a TI",
                delete: {
                    title: "Tem certeza que deseja excluir?",
                    message: "Ao confirmar você exclui o Ramal da lista. Tem certeza que deseja prosseguir?",
                },
            },
        }
    },
    methods: {
        remove(id, index) {
            Alert.YesNo(this.alert.delete.title, this.alert.delete.message).then(res => {
                if(res) {
                    this.ramals.splice(index, 1)
                    model.doDelete(id).then(res => { }, 
                        err => {
                            Alert.Confirm(this.alert.info).then(res => this.$router.go() )
                        })
                }
            })
        },
        unactive(ramal) {
            ramal.active = !ramal.active
            model.doUnactive(ramal.id).then(res => { },
                err => {
                    Alert.Confirm(this.alert.info)
                    ramal.active = !ramal.active
                } )
        }
    },
    mounted() {
        getter.getAllRamals().then( res => { this.ramals = res })
        
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                let list = ''
                return this.ramals.filter(ramals => {
                    if( exp.test(ramals.core)) {
                        return exp
                    } else if( exp.test(ramals.group.name)) {
                        return exp
                    } else if( exp.test(ramals.group.enterprise)) {
                        return exp
                    } else if( exp.test(ramals.number)) {
                        return exp
                    } else if( exp.test(ramals.id)) {
                        return exp
                    } else if( exp.test(ramals.floor)) {
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