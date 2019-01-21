<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <router-link class="button btn btn-outline-secondary btn-lg" :to="{name: 'documentos-eletronicos/add'}" tag="button">
            Criar Documento
        </router-link>

        
        <div class="form-group form-row col mt-3">
            <input type="search" class="filter form-control" :disabled="!documents" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <big-table length="1180">

            <thead>
                <tr>
                    <th scope="col">Protocolo</th>
                    <th scope="col">Assunto</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Criador</th>
                    <th scope="col">Status</th>
                    <th scope="col">Acompanhando</th>
                    <th scope="col">Rascunho</th>
                    <th scope="col">Última Atualização</th>
                    <th scope="col"></th>

                </tr>
            </thead>
            <tbody>
                <tr v-for="(document, index) in searchList" :key="document.id">
                    <th>{{ document.id }}</th>
                    <td>{{ document.subject }}</td>
                    <td>{{ document.type.code }}</td>
                    <td>{{ document.user.name.substr(0, 10) }}...</td>
                    <td>{{ document.status.name }}</td>
                    <td>
                        <div v-for="signature in document.userList" :key="signature.id" v-if="signature.bc">
                            <div class="text-left"><icon icon="angle-double-right"/>
                                <i>{{ signature.user.name.substr(0, 10) }}...</i> - <b>A/C</b>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="checkbox" v-model="document.draft" disabled>
                    </td>
                    <td>{{ document.c_modified.date | humanizeDate }}</td>
                    <td>
                        <router-link :to='`documentos-eletronicos/edit/${document.id}`'>
                            <icon icon="edit"/>
                        </router-link>
                        <router-link @click.native="remove(document.id, index)" to=''>
                            <icon class="text-danger" icon="trash-alt"/>
                        </router-link>
                    </td>

                </tr>
            </tbody>

        </big-table>
        
    </div>
</template>

<script>
import BigTable from "@/components/shared/BigTable";
import { getter } from "@/model/eletronic-documents-model";

export default {
    data: () => ({
        title: "Documentos Eletrônicos",
        documents: [],
        filter: ''
    }),
    computed: {
        searchList() {
            if(this.filter) {
                let exp = new RegExp(this.filter.trim(), 'i')
                
                let list = ''
                return this.documents.filter(document => {
                    if( exp.test(document.subject)) {
                        return exp
                    } else if( exp.test(document.id)) {
                        return exp
                    } else if( exp.test(document.type.code)) {
                        return exp
                    } else if( exp.test(document.user.name)) {
                        return exp
                    } else if( exp.test(document.satus.code)) {
                        return exp
                    } else if( exp.test(document.type.code)) {
                        return exp
                    } else if( exp.test( this.$options.filters.humanizeDate(document.c_modifiec.date) ) ) {
                        return exp
                    }
                })
            } else {
                return this.documents
            }
        },
    },
    mounted() {
        getter.getEletronicDocuments().then(res => { this.documents = res; console.log(res[0]);
         })
    },
    components: {
        'big-table': BigTable,
    }
}
</script>

<style scoped>

</style>