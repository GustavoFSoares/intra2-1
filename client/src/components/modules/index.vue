<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'modulos/add'}" tag="button">
            Criar Modulo
        </router-link>
        <router-link class="button btn btn-outline-primary btn-lg" :to="{name: 'modulos/permissoes'}" tag="button">
            Gerenciar Permissões
        </router-link>

        <div id="table" class="list-group">
            <div v-for="(module, index) of modules" :key="index" class="">
                <router-link to="" class="list-group-item list-group-item-action" v-bind:class="{ 'list-group-item-danger': !module.active }" data-toggle="collapse" :data-target="'#id'+index" aria-expanded="true" :aria-controls="'id'+index">
                    <icon :icon="module.icon"/> - {{ module.name }}
                </router-link>

                <div :id="'id'+index" class="collapse" data-parent="#table">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Icone:</th>
                                <th>Nome:</th>
                                <th>Padrão:</th>
                                <th>Última Modificação:</th>
                                <th>Status:</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>{{ module.id }}</th>
                                    <td>
                                        <icon :icon="module.icon"/>
                                    </td>
                                    <td>{{ module.name }}</td>
                                    <td>
                                        <input type="checkbox" v-model="module.default" disabled>
                                    </td>
                                    <td>{{ moment(module.c_modified.date).format('DD/MM/YYYY - hh:mm:ss') }}</td>
                                    <td @dblclick="changeStatus(module)">
                                        <i class="text-success fa fa-check-circle" v-if="module.active"/>
                                        <i class="text-danger fa fa-times-circle" v-else/>
                                    </td>
                                    <td>
                                        <router-link :to='`modulos/edit/${module.id}`'>
                                            <icon icon="edit"/>
                                        </router-link>
                                        <router-link @click.native="remove(module, index, 'module')" to="">
                                            <icon icon="trash-alt" class="text-danger"/>
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div id="chield-module" class="container-fluid" v-if="module.children">
                            <h3 class="text-center">Módulos Filhos</h3>
                            <table class="table">
                                <thead>
                                    <th></th>
                                    <th>Icone:</th>
                                    <th>Nome Filho:</th>
                                    <th>Status:</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(chield, index) in module.children" :key="index">
                                        <th scope="row">{{ index }}</th>
                                        <td> <icon :icon="chield.icon"/> </td>
                                        <td>{{ chield.name }}</td>
                                        <!-- <td>{{ moment(chield.c_modified.date).format('DD/MM/YYYY - hh:mm:ss') }}</td> -->
                                        <td @dblclick="changeStatus(chield)">
                                            <i class="text-success fa fa-check-circle" v-if="chield.active"/>
                                            <i class="text-danger fa fa-times-circle" v-else/>
                                        </td>
                                        <td>
                                            <router-link :to='`modulos/edit/${chield.id}`'>
                                                <icon icon="edit"/>
                                            </router-link>
                                            <router-link @click.native="remove(module, index, 'chield')" to="">
                                                <icon class="text-danger" icon="trash-alt"/>
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>   
</template>

<script>
import { FormRw, FormRws } from "@/components/shared/Form";
import model, { getter } from "@/model/modules-model";
import moment from 'moment'
import Alert from '@/components/shared/Alert'

export default {
    data() {
        return {
            title: "Lista de Módulos",
            modules: [],
            moment: moment,
            alert: {
                info: "Houve um erro ao tentar modificar o Modulo.",
                delete: {
                    title: "Tem certeza que deseja excluir?",
                    message: "Ao confirmar você exclui o Modulo. Tem certeza que deseja prosseguir?",
                },
            },
        }
    },
    methods: { 
        remove(module, index, type){
            Alert.YesNo(this.alert.delete.title, this.alert.delete.message).then(res => {
                if(res) {
                    let id
                    if(type != 'chield') {
                        id = module.id
                        this.modules.splice(index, 1)
                    } else {
                        id = module.children[index].id
                        module.children.splice(index, 1)
                    }

                    model.doDeleteModule(id).then(res => {},
                        err => {
                            Alert.Confirm(this.alert.info).then(res => this.$router.go())
                        })
                }
            })
        },
        changeStatus(module){
            module.active = !module.active
            model.doChangeStatusModule(module.id).then(res => {},
                err => {
                    module.active = !module.active
                    Alert.Confirm(this.alert.info)
                })

        }
        
    },
    mounted() {
        getter.getModules().then(res => { this.modules = res })
    },
    components: {
        'row': FormRw,
        'rows': FormRws
    }
}
</script>

<style lang="scss" scoped>
    .space {
        margin-top: 3%;
    }

    .classe {
        color: #575757d3;
    }

    #table {
        margin-top: 10px;
        text-align: left;
    }

    #chield-module {
        margin-top: 20px;
        margin-left: 2%;
        width: 95%;
    }
</style>

