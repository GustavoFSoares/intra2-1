<template>
    <div class="container-fluid">

        <div id="revoked" v-if="document.status && document.status.id == 'revoked'">
            <hr>
            <h1>Revogado</h1>
            <hr>
        </div>

        <h1>{{ title }}</h1>

        <actual-status :actualStatusId="document.status" :documentId="id"/>
        <section>
            <text-exibitor :document="document"/>            
        </section>

        <section id="signature-area">
            <sign-document :id="id" v-model="document" :disabled="!document.status || document.status.id == 'revoked'" title="Assinar Documento" ref="sign_document" :show="canShowSignature"/>
        </section>

        <section id="buttons">
            <row>
                <router-link class="btn btn-outline-primary btn-lg" :to="{name: 'documentos-eletronicos'}" tag="button">
                    Voltar
                </router-link>
                <button class="btn btn-outline-danger btn-lg" id="submit-button" type="button" :disabled="true">
                    Arquivar Documento
                </button>
            </row>
        </section>
    </div>
</template>

<script>
import ActualStatus from "./complements/ActualStatus"
import SignDocument from './complements/SignDocument.vue'
import SignatureForm from './complements/SignatureForm.vue'
import VmfilePdf from '@/components/shared/VFile/V-multifile-pdf.vue'
import TextExibitor from "./complements/TextExibitor";

import EletronicDocument from "@/entity/EletronicDocuments";
import model, { getter } from "@/model/eletronic-documents-model"
export default {
    data() {
        return {
            title: "Assinar Documento",
            id: this.$route.params.id,
            document: new EletronicDocument(),
            canShowSignature: false,
        }
    },
    methods: {
        loadValues() {
            if(this.id) {
                getter.getEletronicDocumentById(this.id).then( res => { 
                    this.document = new EletronicDocument(res); 
                    this.title = this.document.type.name
                    this.canShowSignature = true

                    if(this.document.status.id == 'sending') {
                        this.setLikeWaitingSignature()
                    }
                })
            }
        },
        updateSignature(data) {
            let signature = this.document.signatureList.find(signature => {
                return signature.user.id == data.id
            })
            signature.signed = data.signed;
            signature.status = data.status;
        },
        setLikeWaitingSignature() {
            //Se próximo Usuário == Usuário da Sessão
            getter.getNextUserToSign(this.id).then(res => {
                if( res != null && res.id == this.$session.get('user').id) {
                    //Setar Documento como "Aguardando Assinatura"
                    model.setLikeWaitingSignature(this.id).then(res => {
                        this.document.status = res
                    })
                }
                
            })
        }
    },
    components: {
        'v-multifile-pdf': VmfilePdf,
        'signature-form': SignatureForm,
        'sign-document': SignDocument,
        'actual-status': ActualStatus,
        'text-exibitor': TextExibitor,
    },
    mounted() {
        this.loadValues()
    },
}
</script>

<style scoped>
    #content {
        margin-right: 3%;
        margin-left: 3%;
    }

    .date {
        text-align: right;
        margin-right: 20px;
        margin-top: -15px;
    }

    #revoked {
        display: block;
        position: absolute;
        color: var(--danger);
        transform: rotate(-45deg);
        width: 350px;
        top: 150px;
    }

    #revoked h1 {
        font-size: 60px;
    }
    
    #revoked hr {
         border-top: 2px solid var(--danger);
    }
</style>

