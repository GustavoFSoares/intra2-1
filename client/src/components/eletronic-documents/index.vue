<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>

        <div class='row'>
            <rows label=''>
                <button class="button btn btn-outline-secondary btn-lg" v-bind:class="{ 'active': showFiled }" @click="showFiled = !showFiled">
                    Mosrtar Arquivados
                </button>                
            </rows>
            
            <rows label=''>
                <router-link class="button btn btn-outline-primary btn-lg" :to="{name: 'documentos-eletronicos/add'}" tag="button">
                    Criar Documento
                </router-link>                
            </rows>

            <rows label=''> </rows>
        </div>
        
        <div class="form-group form-row col mt-3">
            <input type="search" class="filter form-control" :disabled="!documents" @input="filter = $event.target.value" placeholder="Pesquisa:"/>
        </div>

        <big-table field_length="180" class="table-hover">

            <thead>
                <tr>
                    <th scope="col">Protocolo</th>
                    <th scope="col">Assunto</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Criador</th>
                    <th scope="col">Status</th>
                    <th scope="col">Acompanhando</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr @click="showMore(document)" v-for="(document, index) in searchList" :key="document.id" class="row-list" :class="getColorStatus(document.status.id)">
                    <th>{{ document.id }}</th>
                    <td>{{ document.subject }}</td>
                    <td>{{ document.type.code }}</td>
                    <td>{{ document.user.name.substr(0, 10) }}...</td>
                    <td>{{ document.status.name }}</td>
                    <td>
                        <div v-for="signature in document.signatureList" :key="signature.id" v-if="signature.bc">
                            <div class="text-left"><icon icon="angle-double-right"/>
                                <i>{{ signature.user.name.substr(0, 10) }}...</i> - <b>A/C</b>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="" @click.stop.prevent="$router.push(`documentos-eletronicos/edit/${document.id}`)" v-if="showEditButton(document.status, document.user)">
                            <icon v-tooltip.top="'Editar'" icon="edit"/>
                        </a>
                        <a href="" @click.stop.prevent="$router.push(`documentos-eletronicos/detalhe/${document.id}`)" v-else>
                            <icon v-tooltip.top="'Detalhe'" class="text-warning" icon="search"/>
                        </a>
                        <a @click.stop.prevent="remove(document.id, index)" to='' v-if="showDeleteButton(document.status, document.user)">
                            <icon v-tooltip.top="'Excluir'" class="text-danger" icon="trash-alt"/>
                        </a>
                        <a @click.stop.prevent="archive(document, index)" to='' v-if="showArchiveButton(document.status, document.user)">
                            <icon v-tooltip.top="'Arquivar'" class="text-secondary" icon="archive"/>
                        </a>
                    </td>

                </tr>
            </tbody>

        </big-table>
        
        <modal ref="modal" :title="`<b>Protocolo:</b> ${documentSelected.id}`">
            <show-more :document="documentSelected"/>
        </modal>
    </div>
</template>

<script>
import BigTable from "@/components/shared/BigTable";
import Modal from "@/components/shared/Modal";
import ShowMore from "./complements/ShowMore";
import model, { getter } from "@/model/eletronic-documents-model";

export default {
    data: () => ({
        title: "Documentos Eletrônicos",
        documents: [],
        documentSelected: false,
        filter: '',
        user: $session.get('user'),
        showFiled: false,
    }),
    methods: {
        showMore(document) {
            this.documentSelected = document
            this.$refs.modal.show()
        },
        getColorStatus(statusId) {
            let colorClass = ''
            
            switch (statusId) {
                case 'draft':
                    colorClass = 'table-primary'
                    break;

                case 'finished':
                    colorClass = 'table-success'
                    break;
            
                case 'revoked': 
                case 'canceled': 
                    colorClass = 'table-danger'
                    break;

                case 'filed':
                    colorClass = 'table-disabled'
                    break;
                    
                default:
                    break;
            }

            return colorClass
        },
        showEditButton(status, user) {
            if(user.id != this.user.id) {
                return false
            } else if(status.id == 'draft' || status == '') {
                return true
            } else {
                return false
            }
        },
        showDeleteButton(status, user) {
            if(user.id != this.user.id) {
                return false
            } else if(status.id == 'draft' || status == '') {
                return true
            } else {
                return false
            }
        },
        showArchiveButton(status, user) {
            if(user.id != this.user.id) {
                return false
            } else if(status.id == 'finished' 
                        || status.id == 'canceled'  
                        || status.id == 'revoked'
                    ) {
                return true
            } else {
                return false
            }
        },
        showDocumentIfFiled(document) {
            if( this.showFiled ) {
                if( document.status.id == 'filed' ) {
                    return document
                }
            } else {
                if( document.status.id != 'filed') {
                    return document
                }
            }
        },
        archive(document, index) {
            model.setLikeFiled(document).catch(err => {
                setTimeout(() => {
                    this.$router.go()
                }, 5000);
            })
        }
    },
    computed: {
        secondFilter() {
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
                    } else if( exp.test(document.status.name)) {
                        return exp  
                    }
                    
                })
            } else {
                return this.documents
            }
        },
        searchList() {
            return this.secondFilter.filter(document => {
                return this.showDocumentIfFiled(document)
            })
        },
    },
    mounted() {
        getter.getEletronicDocuments().then(res => { this.documents = res; console.log(res[0]);
         })
    },
    components: {
        'big-table': BigTable,
        'modal': Modal,
        'show-more': ShowMore,
    }
}
</script>

<style scoped>
    .row-list:hover {
        cursor: pointer;
    }
</style>