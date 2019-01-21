<template>
    <div class="container-fluid">

        <h1>{{ title }}</h1>
        <section id="document-box" class='row'>
            <rows>
                <div id="document-configurations">
                    <box>
                        
                        <row>
                            <h4><b>Protocolo: </b>{{ document.id }}</h4>
                        </row>
                        <row>
                            <visit-card :user="document.user"/>
                        </row>

                        <box>
                                
                            <row label='Assunto'>
                                <input class="form-control" v-model="document.subject" type="text">
                            </row>

                            <div class='row'>
                                <rows label='Tipo' class="col-md-9">
                                    <v-select label="name" v-model="document.type" :options="values.types"></v-select>
                                </rows>
                                <rows>
                                    <label></label>
                                    <div class="form-check">
                                        <input type="checkbox" v-model="document.draft" class="form-check-input" id="rascunho">
                                        <label class="form-check-label" for="rascunho">Rascunho</label>
                                    </div>
                                </rows>
                            </div>

                        </box>

                        <row>
                            <box>
                                <info-icon :message="tooltipMessage.userAndGroup"/>
                                <add-and-remove-users v-model="document.userList"/>
                                <hr>
                                <add-and-remove-groups v-model="document.groupList"/>
                            </box>
                        </row>

                    </box>
                </div>
            </rows>
            <rows >
                <div id="editor-space">
                    <box>
                        <text-editor v-model="document.content" ref="txt"/>
                    </box>
                </div>
            </rows>
        </section>

        <section>
            <v-multifile-pdf :id="document.id" :post_function="sendFile"/>
        </section>

        <div id="buttons">
            <row>
                <button v-if="!document.draft" class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="submit()" :disabled="sending">
                    Registrar Documento
                </button>
                <button v-else class="btn btn-outline-warning btn-lg" id="submit-button" type="button" @click="saveDraft()" :disabled="sending">
                    Salvar Rascunho
                </button>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'documentos-eletronicos'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
            </row>
        </div>
        
        <sign-document :id="id" v-model="document" title="Assinar Documento" ref="sign_document"/>
    </div>
</template>

<script>
import UserVisitCard from "@/components/shared/UserVisitcard.vue"
import TextEditor from '@/components/shared/TextEditor.vue'
import Vmfilefdf from '@/components/shared/VFile/V-multifile-pdf.vue'
import AddAndRemoveUsers from './complements/AddAndRemoveUsers.vue'
import SignDocument from './complements/SignDocument.vue'
import AddAndRemoveGroups from '@/components/shared/AddAndRemove/AddAndRemoveGroups.vue'

import EletronicDocument from "@/entity/EletronicDocuments";
import model, { getter } from "@/model/eletronic-documents-model"
export default {
    data() {
        return {
            id: this.$route.params.id,
            title: "Cadastro de Documento",
            showSignature: false,
            values: {
                types: [],
            },
            tooltipMessage: {
                userAndGroup: "Mensagem para usuario e grupo<br><ul><li>Usuario</li><li>grupo</li></ul>"  
            },
            document: new EletronicDocument(),
            sending: false
        }
    },
    methods: {
        loadValues() {
            getter.getTypes().then(res => { this.values.types = res; })
            if(this.id) {
                getter.getEletronicDocumentById(this.id).then( res => { this.document = new EletronicDocument(res); })
            }
        },
        sendFile: (file, fileName, prefix) => model.doUploadFile(file, fileName, prefix),
        submit() {
            this.$refs.sign_document.show()
        },
        saveDraft() {
            this.sending = true
            if(this.isEdit()) {
                model.doUpdate(this.document).then(res => {
                    this.sending = false
                    this.$router.push({ name: 'documentos-eletronicos' })
                }).catch(err => {
                    this.sending = false
                })
            } else {
                model.doInsert(this.document).then(res => {
                    this.sending = false
                    this.$router.push({ name: 'documentos-eletronicos' })
                }).catch(err => {
                    this.sending = false
                })
            }
        },
        isEdit() {
            return model.isEdit(this.id)
        }
    },
    mounted() {
        this.loadValues()
    },
    components: {
        'text-editor': TextEditor,
        'v-multifile-pdf': Vmfilefdf,
        'visit-card': UserVisitCard,
        'add-and-remove-users': AddAndRemoveUsers,
        'add-and-remove-groups': AddAndRemoveGroups,
        'sign-document': SignDocument,
    }
}
</script>

<style scoped>
    
</style>