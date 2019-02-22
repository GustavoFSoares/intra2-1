<template>
    <div v-if="show" v-bind:class="{'disabled': disabled}">
        <row>
            <div class='row' v-if="document.user.id == user.id || document.signed || true" >
                <rows class="col-md">
                    {{ document.user.name }}
                </rows>
            </div>
        </row>
            
        <row>
            <h3>Assinar Documento:</h3>
            
            <table v-if="document.signatureList" class="table table-striped">
                <thead>
                    <th>Nome</th>
                    <th>A/C</th>
                    <th>Assinatura Eletrônica</th>
                    <th class="text-center">Situação</th>
                </thead>
                        
                <tbody>
                    <tr v-for="(signature, index) in document.signatureList" :key="index">
                        <td> {{ signature.user.name }} </td>
                        <td>
                            <input type="checkbox" v-model="signature.bc" :disabled="user.id != document.user.id" @change="anyOneBeCare">
                        </td>
                        <td>
                            <signature-form :id="id" :disabled="disabled" :user_id="signature.user.id" :signed="signature.signed" @signed="updateSignatureForUserList"/>
                        </td>
                        <td class="text-center">
                            <span class="text-success bold" v-if="signature.agree === true"> OK </span>
                            <span class="ml-3" v-else-if="signature.agree == null || signature.agree === ''"> - </span>
                            <span class="text-danger bold" v-else-if="signature.agree === false"> NEGADO </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </row>

    </div>
</template>

<script>

import model from "@/model/eletronic-documents-model";
import SignatureForm from './SignatureForm.vue'
import EletronicDocument from "@/entity/EletronicDocuments";
export default {
    data: () => ({
        user: $session.get('user'),
        document: new EletronicDocument(),
        password: '',
        loading: false,
    }),
    props: {
        id: { default: false },
        title: '',
        value: '',
        show: false,
        disabled: { default: false }
    },
    watch: {
        show(value) {
            if(value) {
                this.document = this.value
                this.anyOneBeCare()
            }
        }
    },
    methods: {
        updateSignatureForDocument(signed) { 
            model.signDocumentLikeCreator(this.id, { 
                'user_id': this.document.user.id, 'document_id': this.id, 'agree': signed, 
            }).catch(err => {
                setTimeout(() => { this.$router.go() }, 2000);
            })
            
            this.document.signed = signed
        },
        updateSignatureForUserList(signature) { 
            Object.assign(signature, { 'document_id': this.id })
            model.signDocumentLikeUser(this.id, signature).then(res => {
                this.$emit('signed', res)
            }).catch(err => {
                setTimeout(() => { this.$router.go() }, 2000);
            })

            return this.document.signatureList.find(el => {
                if(el.user.id == signature.user_id) {
                    Object.assign(el, signature)
                }
            })
        },
        doLogin() {
            this.loading = true
            const LoginModel = require('@/model/login-model').default
            const Alert = require('@/components/shared/Alert').default
            
            LoginModel.doAuth({ 'id': this.user.id, 'password': this.password }).then( res => {
                if(res.status) {
                    if(this.id) {
                        this.updateSignatureForDocument(true)
                    }
                    this.document.signed = true
                    this.emit('input', this.document)
                } else {
                    Alert.Confirm(res.message)
                    this.loading = false
                }
                this.loading = false
            }).catch( err => {
                this.loading = false
            })
        },
        anyOneBeCare() {
            let exist = this.document.signatureList.find(el => {
                if(el.bc) {
                    return true
                }
            });
            let has = exist ? true : false
            this.$emit('anyOneBeCare', has)
            
            return has
        },
    },
    components: {
        'signature-form': SignatureForm
    },
    mounted() {
        this.anyOneBeCare()
    }
}
</script>

<style scoped>
    
</style>

