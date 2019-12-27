<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <div class="mb-4">
            <router-link class=" button btn btn-outline-secondary btn-lg" :to="{name: 'sector/add'}" tag="button">
                Cadastrar Setor
            </router-link>
        </div>

        <div class="form-group form-row col">
            <input type="search" class="filter form-control" :disabled="!sectors" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Data de Modificação</th>
                    <th scope="col">Editar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(sector, index) in searchList" :key="sector.id">
                    <td>{{ sector.id }}</td>
                    <td>{{ sector.name }}</td>
                    <td>{{ sector.enterprise }}</td>
                    <td>{{ sector.c_modified.date | humanizeDate }}</td>
                    <td>
                        <router-link :to='`setores/edit/${sector.id}`'>
                            <icon icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(sector.id, index)" to=''>
                            <icon class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import model, { getter } from "@/model/sector-model";
import Alert from "@/components/shared/Alert";

export default {
    data() {
        return {
            title: "Lista de Setores",
            sectors: "",
            filter: "",
            alert: {
                delete: {
                    title: "Tem certeza que deseja excluir?",
                    message: "Ao confirmar você exclui o Setor da lista. Tem certeza que deseja prosseguir?",
                },
            },
            
        }
    },
    methods: {
        remove(id, index) {
            Alert.YesNo(this.alert.delete.title, this.alert.delete.message).then(res => {
                if(res) {
                    this.sectors.splice(index, 1)
                    model.doDelete(id)
                }
            })
        },
        changeStatus(sector) {
            model.changeStatus(sector).catch( err => {
                Alert.Confirm(this.alert.info)
                sector.active = !sector.active
            })
        }
    },
    mounted() {
        getter.getSectors().then( res => { this.sectors = res; })
    },
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                return this.sectors.filter(sector => {
                    if( exp.test(sector.id)) {
                        return exp
                    } else if( exp.test(sector.name)) {
                        return exp
                    } else if( exp.test(sector.enterprise)) {
                        return exp
                    } else if( exp.test( this.$options.filters.humanizeDate(sector.c_modified.date) ) ) {
                        return exp
                    }
                })
            } else {
                return this.sectors
            }
        }
    },
}
</script>