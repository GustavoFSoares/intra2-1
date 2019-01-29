<template>
    <div class="container-fluid">

        <h1>{{ title }}</h1>

        <actual-status :actualStatusId="document.status"/>
        <section>
            <row label=''>
                <h4>
                    <span class="bold"> Protocolo: </span> {{ document.id }}
                </h4>
            </row>

            <box class="border-secondary" v-if="document.content">
                <row>
                    <h1>{{ document.subject }}</h1>
                </row>

                <hr>
                <row>
                    <div id="content">
                        <p>Prezados: </p>
                        
                        <div>
                            <div v-html="document.content"></div>
                        </div>
                    </div>
                    <signature :username="`${document.user.name} - ${document.user.code}`"/>
                    <p class="date">{{ document.createdAt | humanizeDate }}</p> 
                </row>
            </box>
        </section>

        <section>
            <sign-document :id="id" v-model="document" title="Assinar Documento" ref="sign_document" :show="canShowSignature"/>
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
import Signature from "@/components/shared/Signature";

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
                })
            }
        },
        updateSignature(data) {
            let signature = this.document.signatureList.find(signature => {
                return signature.user.id == data.id
            })
            signature.signed = data.signed;
            signature.status = data.status;
            
        }
    },
    components: {
        'v-multifile-pdf': VmfilePdf,
        'signature-form': SignatureForm,
        'sign-document': SignDocument,
        'actual-status': ActualStatus,
        'signature': Signature,
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
</style>

