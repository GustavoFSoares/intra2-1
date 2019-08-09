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

                        </box>
                        <row>
                            <box>
                                <info-icon id="info-icon" title="VAMOS COMEÇAR?" size="1" ref="infoIcon">
                                    Para criar sua lista de envio para os responsáveis que devem autorizar
                                    o documento basta seguir o passo a passo:
                                    <ul class="alert-list">
                                        <li>Pesquiar na barra de pesquisa nome completo ou parcial do responsável;</li>
                                        <li>
                                            Após os resultados da pesquisa serem exibidos, selecione o responsável;
                                            <fieldset>
                                                <i>OBS: Lembre-se, a ordem de autorização é obedecida conforme as posições
                                                    dos usuários na lista
                                                </i>
                                            </fieldset>
                                        </li>
                                        <li>
                                            Voce pode alterar as posições de envio clicando e arrastando para cima ou para baixo;
                                        </li>
                                    </ul>
                                </info-icon>
                                <row>
                                    <add-and-remove-users v-model="document.signatureList" title="Lista de Responsáveis"/>
                                </row>
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

                <box>
                    <h3>Anexar Documentos</h3>
                    <section>
                        <v-multifile-pdf :id="document.id" :post_function="sendFile" origin='eletronic-documents'/>
                    </section>
                </box>
            </rows>
        </section>

        <div id="buttons">
            <row>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'documentos-eletronicos'}" tag="button" :disabled="sending">
                    Voltar
                </router-link>
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
            title: "Retificação de Documento",
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
                    if(res.status.id == 'waiting-correction' || res.status.id == 'draft' || res.status.id == 'canceled' || res.status == "") {
                        this.document = new EletronicDocument(res);
                        delete(this.document.amendmentList);
                        this.block = false
                    }else {
                        this.$alert.danger('Documento Bloqueado para Edição')
                    }
                })
            }
        },
        sendFile: (file, fileName, prefix) => model.doUploadFile(file, fileName, prefix),
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
        openModal() {
            this.isValidForm().then(() => {
                if( this.document.signatureList.length != 0 ) {
                    this.document.draft = false
                    this.constructModal = true
                    this.$refs.modal.show()
                } else {
                    this.$alert.danger("Você precisa adicionar um <i>Usuário Responsável</> para cadastrar o documento")
                    this.$refs.infoIcon.show()
                }
            })
        },
        saveDraft() {
            this.isValidForm().then(() => {
                this.document.draft = true
                this.submit()
            })
        },
        isValidForm() {
            return new Promise(resolve => {
                this.$validator.validateAll().then(success => success ? resolve() : this.$alert.danger(`Erro no formulário. Favor verificar campo "${this.$validator.fields.items[0].alias}"`) )
            })
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

<style lang="scss" scoped>
    .alert-list {
        list-style: none;
        counter-reset: li;

        li {
            counter-increment: li;

            &::before {
                margin-right: 4px;
                content: counter(li);
                font-weight: bold;
            }
        }
    }
</style>