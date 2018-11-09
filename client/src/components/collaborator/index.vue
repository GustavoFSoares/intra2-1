<template>
    <div class="container-fluid">
        
        <div class="mb-2"></div>
        <div class="mb-4">
            <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'colaboradores/add'}" tag="button">
                Cadastrar Colaborador
            </router-link>
        </div>

        <div class="mb-3">
            <div class="btn-group" role="group" aria-label="Basic example">
                <router-link to="" class="btn btn-primary" v-for="(type, index) in types" :key="index" @click.native="search.type = type">{{ type.name }}</router-link>
                <router-link to="" class="btn btn-primary" @click.native="search.type = {id: '', name: ''}">Todos</router-link>
            </div>
        </div>
        
        <div class="form-group form-row col">
            <input type="search" class="filter form-control" :disabled="!collaborators" @input="search.filter = $event.target.value" placeholder="Nome:"/>
        </div>

        <h2>{{ typeExibited }}</h2>

        <table v-if="collaborators" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Setor</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Início</th>
                    <th scope="col">Termino</th>
                    <th scope="col">Turno</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(collaborator) of searchList" :key="collaborator.id" v-bind:class="{'table-danger': !collaborator.active == '1'}">
                    <td>{{ collaborator.id }}</td>
                    <td>{{ collaborator.name }}</td>
                    <td>{{ collaborator.complement.type.name }}</td>
                    <td>{{ collaborator.occupation }}</td>
                    <td>{{ collaborator.group.name }}</td>
                    <td>{{ collaborator.group.enterprise }}</td>
                    <td>{{ moment(collaborator.complement.hire.date).format('DD/MM/YYYY') }}</td>
                    <td>{{ moment(collaborator.complement.fire.date).format('DD/MM/YYYY') }}</td>
                    <td>{{ collaborator.complement.turn }}</td>
                    <td>
                        <icon class="text-success" icon="check-circle" v-if="collaborator.active"/>
                        <icon class="text-danger" icon="times-circle" v-else/>
                    </td>
                    <td>
                        <router-link :to='`colaboradores/edit/${collaborator.id}`'>
                            <icon v-tooltip.top="'Editar'" icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(collaborator.id)" to="">
                            <icon v-tooltip.top="'Remover'" class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import model, { getter } from '@/model/collaborator-model'
import moment from 'moment'
import Alert from "@/components/shared/Alert"

export default {
    data() {
        return {
            typeExibited: '',
            collaborators: [],
            moment: moment,
            search: {
                filter: '',
                type: ''
            },
            types: '',
            alert: {
                remove: { title: "Tem certeza que deseja excluir?", message: "Você está excluindo um Colaborador. <BR>Tem certeza que deseja continuar?" }
            }
        }
    },
    methods: {
        mounteCollaborators() {
            getter.getCollaborators().then(res => {this.collaborators = res; console.log(res) })
            getter.getCollaboratorTypes().then(res => {this.types = res })
        },
        remove(id, index){
            Alert.Confirm(this.alert.remove.message).then(res => {
                if(res){
                    model.doDelete(id)
                    this.collaborators.splice(index, 1)
                }
            })
        },
    },
    mounted() {
        this.mounteCollaborators()
    },
    computed: {
        searchList() {

            if(this.search.type) {
                this.typeExibited = this.search.type.name
                let type = new RegExp(this.search.type.id.trim(), 'i')
                
                return this.collaborators.filter(collaborators => {
                    if( type.test(collaborators.complement.type.id )) {
                        return type
                    }
                })

            }
            
            if(this.search.filter) {
                let exp = new RegExp(this.search.filter.trim(), 'i')
                
                return this.collaborators.filter(collaborators => {
                    
                    if( exp.test(collaborators.id)) {
                        return exp
                    } else if( exp.test(collaborators.name)) {
                        return exp
                    } else if( exp.test(collaborators.group.name)) {
                        return exp
                    } else if( exp.test(collaborators.occupation)) {
                        return exp
                    } else if( exp.test(collaborators.group.enterprise)) {
                        return exp
                    } else if( exp.test(collaborators.complement.turn)) {
                        return exp
                    } else if( exp.test(moment(collaborators.complement.hire.date).format('DD/MM/YYYY'))) {
                        return exp
                    } else if( exp.test(moment(collaborators.complement.fire.date).format('DD/MM/YYYY'))) {
                        return exp
                    }
                })
            } else {
                return this.collaborators
            }
        }
    },
}
</script>

<style scoped>

</style>
