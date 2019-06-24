<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>
        
        <div class="mb-4">
            <router-link class=" button btn btn-outline-secondary btn-lg" :to="{name: 'link/add'}" tag="button">
                Cadastrar Link
            </router-link>
        </div>

        <div class="form-group form-row col">
            <input type="search" class="filter form-control" :disabled="!links" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Título</th>
                    <th scope="col">URL</th>
                    <th scope="col">Externo</th>
                    <th scope="col">Última Atualização</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(link, index) in searchList" :key="link.id" v-bind:class="{ 'table-danger' : !link.active }">
                    <td>{{ link.title }}</td>
                    <td>
                        <router-link v-if="!link.externalLink" :to="link.url" target='_blank'> {{ link.url }} </router-link>
                        <a v-else :href="link.url" target='_blank'> {{ link.url }} </a>
                    </td>
                    <td> 
                        <span class="text-success bold" v-if="link.externalLink"> SIM </span>
                        <span class="text-danger bold" v-else> NÃO </span>
                    </td>
                    <td>{{ link.c_modified.date | humanizeDate }}</td>
                    <td @dblclick="changeStatus(link)" v-tooltip.top="'Mudar Status'" class='td-icon'>
                        <icon class="text-success" icon="check-circle" v-if="link.active"/>
                        <icon class="text-danger" icon="times-circle" v-else/>
                    </td>
                    <td>
                        <router-link :to='`link/edit/${link.id}`'>
                            <icon icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(link.id, index)" to=''>
                            <icon class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import model, { getter } from "@/model/link-model";
import Alert from "@/components/shared/Alert";

export default {
    data() {
        return {
            title: "Lista de Links",
            links: "",
            filter: "",
            alert: {
                // info: "Houve um erro ao tentar modificar o Ramal. Por favor tente novamente ou contate a TI",
                delete: {
                    title: "Tem certeza que deseja excluir?",
                    message: "Ao confirmar você exclui o Link da lista. Tem certeza que deseja prosseguir?",
                },
            },
        }
    },
    methods: {
        remove(id, index) {
            Alert.YesNo(this.alert.delete.title, this.alert.delete.message).then(res => {
                if(res) {
                    this.links.splice(index, 1)
                    model.doDelete(id)
                }
            })
        },
        changeStatus(link) {
            model.changeStatus(link).catch( err => {
                    Alert.Confirm(this.alert.info)
                    link.active = !link.active
                })
        }
    },
    mounted() {
        getter.getLinks().then( res => { this.links = res; })
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                return this.links.filter(link => {
                    if( exp.test(link.id)) {
                        return exp
                    } else if( exp.test(link.title)) {
                        return exp
                    } else if( exp.test(link.url)) {
                        return exp
                    } else if( exp.test( this.$options.filters.humanizeDate(link.c_modified.date) ) ) {
                        return exp
                    }
                })
            } else {
                return this.links
            }
        }
    },
}
</script>