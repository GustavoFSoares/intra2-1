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
                <router-link to="" class="list-group-item list-group-item-action" v-bind:class="{ 'list-group-item-danger': module.c_removed }" data-toggle="collapse" :data-target="'#id'+index" aria-expanded="true" :aria-controls="'id'+index">
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
                                    <td @dblclick="changeStatus(module.id)">
                                        <i class="text-success fa fa-check-circle" v-if="!module.c_removed"/>
                                        <i class="text-danger fa fa-times-circle" v-else/>
                                    </td>
                                    <td>
                                        <router-link :to='`modulos/edit/${module.id}`'>
                                            <icon icon="edit"/>
                                        </router-link>
                                        <router-link @click.native="remove(module.id)" to="">
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
                                        <td @dblclick="changeStatus(chield.id)">
                                            <i class="text-success fa fa-check-circle" v-if="!chield.c_removed"/>
                                            <i class="text-danger fa fa-times-circle" v-else/>
                                        </td>
                                        <td>
                                            <router-link :to='`modulos/edit/${chield.id}`'>
                                                <icon icon="edit"/>
                                            </router-link>
                                            <router-link @click.native="remove(chield.id)" to="">
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
    
        <!-- <tbody>
            <tr v-for="(module, index) of modules" :key="index">
                <td scope="row">{{ module.id }}</td>
                <td> <icon :icon="module.icon"/> </td>
                <td>{{ module.name }}</td>
                <td>{{ moment(module.c_modified.date).format('DD/MM/YYYY - hh:mm:ss') }}</td>
                <td @dblclick="changeStatus(module.id)">
                    <i class="text-success fa fa-check-circle" v-if="!module.c_removed"/>
                    <i class="text-danger fa fa-times-circle" v-else/>
                </td>
                <td>
                    <router-link :to='`modulos/edit/${module.id}`'>
                        <i class="fa fa-edit"/>
                    </router-link>
                    <router-link @click.native="remove(module.id)" to="">
                        <i class="text-danger fa fa-trash"></i>
                    </router-link>
                </td>
            </tr>
        </tbody> -->
    </div>   
</template>

<script>
import { FormRw, FormRws } from "@/components/shared/Form";
import model, { getter } from "@/model/modules-model";
import moment from 'moment'

export default {
    data() {
        return {
            title: "Lista de Módulos",
            modules: [],
            moment: moment,
            test: true,
        }
    },
    methods: { 
        remove(id){
            confirm("Tem certeza que deseja excluir?") ?
                model.doDeleteModule(id).then(res => this.$router.go()):''
        },
        changeStatus(id){
            model.doChangeStatusModule(id).then(res => this.$router.go())
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

<style scoped>
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

