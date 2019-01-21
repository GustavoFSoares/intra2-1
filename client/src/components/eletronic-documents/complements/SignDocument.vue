<template>
    <modal ref="modal" :disabled="!anyOneBeCare || sending" :submit_method="submit" :title="title" submitlabel="Enviar" @return="$router.push({ name: 'documentos-eletronicos' })">
        <div v-if="constructModal">
            <row>
                
                <div class='row'>
                    <rows class="col-md">
                        {{ document.user.name }}
                    </rows>
                    
                    <rows class="pull-left">
                        <signature-form :user_id="document.user.id" :signed="document.signed" @signed="writerSigned" />
                    </rows>
                </div>

            </row>
                
            <row>
                
                <h3>Assinaturas dos Responsáveis</h3>
                <div class="row">

                    <div class="col-md">
                        
                        <table v-if="document.userList" class="table table-striped">
                            
                            <thead>
                                <th>Nome</th>
                                <th>A/C</th>
                                <th>Assinar</th>
                            </thead>
                            
                            <tbody>
                                <tr v-for="(signature, index) in document.userList" :key="index">
                                    <td> {{ signature.user.name }} </td>
                                    <td>
                                        <input type="checkbox" v-model="signature.bc">
                                    </td>
                                    <td>
                                        <signature-form :user_id="signature.user.id" :signed="signature.signed" @signed="doLoginCompation"/>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        
                    </div>
                </div>

            </row>
        </div>
    </modal>
</template>

<script>
import { Checkbox } from "@/components/shared/Form"
import LoginModel from "@/model/login-model"
import Modal from "@/components/shared/Modal"

import model from "@/model/eletronic-documents-model";
import SignatureForm from './SignatureForm.vue'
import EletronicDocument from "@/entity/EletronicDocuments";
export default {
    data: () => ({
        user: $session.get('user'),
        document: new EletronicDocument(),
        constructModal: false,
        sending: false,
    }),
    props: {
        id: { default: false },
        title: '',
        value: '',
    },
    methods: {
        show() {
            this.document = this.value
            this.$refs.modal.show()
            this.constructModal = true
        },
        writerSigned(signed) { this.document.signed = signed.status },
        doLoginCompation(signed) {
            this.document.userList.find(el => {
                if(el.user.id == signed.id) {
                    el.signed = signed.status
                }
            })
        },
        submit() {
            this.sending = true
            if(this.isEdit()) {
                return model.doUpdate(this.document).then(res => {
                    this.sending = false
                }).catch(err => {
                    this.sending = false
                })
            } else {
                return model.doInsert(this.document).then(res => {
                    this.sending = false
                }).catch(err => {
                    this.sending = false
                })
            }
        },
        isEdit() {
            return model.isEdit(this.id)
        }
    },
    computed: {
        anyOneBeCare() {
            let exist = this.document.userList.find(el => {
                if(el.bc) {
                    return true
                }
            });
            return exist ? true : false
        }
    },
    components: {
        'modal': Modal,
        'checkbox': Checkbox,
        'signature-form': SignatureForm
    }
}
</script>

<style scoped>
    
</style>

