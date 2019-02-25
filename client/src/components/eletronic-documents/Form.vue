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
                                <input class="form-control" v-model="document.subject" name="EletronicDocument-Subject" data-vv-as="Assunto" v-validate data-vv-rules="required" type="text">
                                <require-text :error="errors.has('EletronicDocument-Subject')" :text="errors.first('EletronicDocument-Subject')"/>
                            </row>

                            <row label='Tipo'>
                                <v-select :disabled="true" label="name" v-model="document.type" :options="values.types"></v-select>
                            </row>

                        </box>

                        <row>
                            <box>
                                <info-icon id="info-icon">
                                    Adicionar usuário ao memorando:
                                    <ul>
                                        <li>
                                            Estes usuários são responsáveis por <b>assinar</b> e <b>validar</b> o documento
                                        </li>
                                    </ul>
                                </info-icon>
                                <row>
                                    <add-and-remove-users v-model="document.signatureList" title="Lista de Responsáveis"/>
                                </row>
                                <!-- <hr>
                                <add-and-remove-groups v-model="document.groupList"/> -->
                            </box>
                        </row>

                    </box>
                </div>
            </rows>
            <rows >
                <box>
                    <div id="editor-space">
                        <text-editor v-model="document.content" ref="txt"/>
                    </div>
                </box>

                <!-- <box>
                    <section>
                        <v-multifile-pdf :id="document.id" :post_function="sendFile"/>
                    </section>
                </box> -->
            </rows>
        </section>

        <div id="buttons">
            <row>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'documentos-eletronicos'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
                <button class="btn btn-outline-warning btn-lg" id="submit-button" type="button" @click="saveDraft()" :disabled="sending" v-if="!block">
                    Salvar Rascunho
                </button>
                <button class="btn btn-outline-secondary btn-lg" id="submit-button" type="button" @click="openModal()" :disabled="sending" v-if="!block">
                    Salvar e Enviar
                </button>
            </row>
        </div>
        
        <modal ref="modal" :disabled="sending || !anyOneBeCare" :submit_method="submit" title="Assinatura de Documento" submitlabel="Enviar" >
            <sign-document :id="id" v-model="document" title="Assinar Documento" ref="sign_document" :show="constructModal" @anyOneBeCare="hasAnyOneBeCare"/>
        </modal>
    </div>
</template>

<script>
import Modal from "@/components/shared/Modal"
import UserVisitCard from "@/components/shared/UserVisitcard.vue"
import TextEditor from '@/components/shared/TextEditor.vue'
import VmfilePdf from '@/components/shared/VFile/V-multifile-pdf.vue'
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
            document: new EletronicDocument(),
            sending: false,
            constructModal: false,
            anyOneBeCare: false,
            block: false,
        }
    },
    methods: {
        loadValues() {
            getter.getTypes().then(res => { this.values.types = res; })
            if(this.id) {
                this.block = true
                getter.getEletronicDocumentById(this.id).then( res => { 
                    if(res.status.id == 'draft' || res.status.id == 'canceled' || res.status == "") {
                        this.document = new EletronicDocument(res); 
                        this.block = false
                    } else {
                        this.$alert.danger('Documento Bloqueado para Edição')
                    }
                })
            }
        },
        sendFile: (file, fileName, prefix) => model.doUploadFile(file, fileName, prefix),
        openModal() {
            this.document.draft = false
            this.constructModal = true
            this.$refs.modal.show()
        },
        submit() {
            this.sending = true
            if(this.isEdit()) {
                return model.doUpdate(this.document).then(res => {
                    this.sending = false
                    this.$refs.modal.close()
                    setTimeout(() => {
                        this.$router.push({ name: 'documentos-eletronicos' })
                    }, 1000);
                }).catch(err => {
                    this.sending = false
                })
            } else {
                return model.doInsert(this.document).then(res => {
                    this.sending = false
                    setTimeout(() => {
                        this.$router.push({ name: 'documentos-eletronicos' })
                    }, 1000);
                }).catch(err => {
                    this.sending = false
                })
            }
        },
        saveDraft() {
            this.document.draft = true
            this.submit()
        },
        isEdit() {
            return model.isEdit(this.id)
        },
        hasAnyOneBeCare(val) {
            this.anyOneBeCare = val
        }
    },
    mounted() {
        this.loadValues()
    },
    components: {
        'text-editor': TextEditor,
        'v-multifile-pdf': VmfilePdf,
        'visit-card': UserVisitCard,
        'add-and-remove-users': AddAndRemoveUsers,
        'add-and-remove-groups': AddAndRemoveGroups,
        'sign-document': SignDocument,
        'modal': Modal,
    }
}
</script>

<style scoped>

</style>