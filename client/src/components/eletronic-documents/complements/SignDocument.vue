<template>
    <div v-if="show">
        <row>
            <div class='row' v-if="document.user.id == user.id || document.signed" >
                <rows class="col-md">
                    {{ document.user.name }}
                </rows>
                
                <rows >
                    <div v-if="document.signed" class="row bold">
                        <icon icon="check" class="text-success col-md-2"/>
                        <p class="text-success col-md"> ASSINADO </p>
                    </div>

                    <div v-else class="row">
                        <div class="col-md-7">
                            <input class="form-control" placeholder="Senha..." type="password" v-model="password" :disabled="loading">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary signed-button" :disabled="loading || !password" @click="doLogin()">
                                Assinar <icon icon="spinner" spin v-if="loading"/>
                            </button>
                        </div>
                    </div>

                </rows>
            </div>
        </row>
            
        <row>
            <h3>Assinar Documento:</h3>
            
            <table v-if="document.userList" class="table table-striped">
                <thead>
                    <th>Nome</th>
                    <th>A/C</th>
                    <th>Assinatura Eletrônica</th>
                    <th>Situação</th>
                </thead>
                        
                <tbody>
                    <tr v-for="(signature, index) in document.userList" :key="index">
                        <td> {{ signature.user.name }} </td>
                        <td>
                            <input type="checkbox" v-model="signature.bc" :disabled="user.id != document.user.id" @change="anyOneBeCare">
                        </td>
                        <td>
                            <signature-form :user_id="signature.user.id" :signed="signature.signed" @signed="updateSignatureForUserList"/>
                        </td>
                        <td>
                            <span class="text-success bold" v-if="signature.agree"> OK </span>
                            <span class="text-danger bold" v-else-if="signature.agree == false"> NEGADO </span>
                            <span class="ml-3" v-else > - </span>
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
            this.document.signed = signed
            console.log('make log - CHEFE');
        },
        updateSignatureForUserList(signature) { 
            return this.document.userList.find(el => {
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
                    this.updateSignatureForDocument(true)
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
            let exist = this.document.userList.find(el => {
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

