<template>
    <div>
        <div v-if="signed" class="row bold">
            <icon icon="check" class="text-success col-md-2"/>
            <p class="text-success col-md"> ASSINADO </p>
        </div>
        <div v-else-if="user.id == user_id && signed == false" class="row">
            <yes-no v-model="agree" yes="Concordar" no="Revogar" :disabled="disabled" v-if="show.button" @click="showPassword()"/>
            <div v-if="show.password" class="row">
                <div class="col-md-1 mt-2">
                    <router-link to="" @click.native="showButton()" v-if="!loading">
                        <icon icon="arrow-left" v-tooltip.top="'Retornar à escolha'"/>
                    </router-link>
                </div>
                <div class="col-md-7">
                    <input @keyup.enter="doLogin()" class="form-control" placeholder="Senha..." type="password" v-model="password" :disabled="loading">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary signed-button" :disabled="loading || !password" @click="doLogin()">
                        Assinar <icon icon="spinner" spin v-if="loading"/>
                    </button>
                </div>
            </div>
            
            <section id="modal-revoket" >
                <modal v-model="showModal" title="Discordar do Documento" ref="modal">
                    <row>
                        <textarea class="form-control" v-model="modal.motivo" placeholder="Motivo:"></textarea>
                    </row>

                    <div class='row text-center'>
                        <rows>
                            <button @click="revokeDocument()" class="btn btn-outline-danger">Negar Documento</button>
                        </rows>
                        
                        <rows>
                            <router-link :to="`/usuario/documentos-eletronicos/criar-emenda/${id}`" class="btn btn-outline-warning">Emenda para Correção</router-link>
                        </rows>
                    </div>
                </modal>
            </section>

        </div>
        <div v-else class="row bold">
            <icon icon="times" class="text-danger col-md-2"/>
            <p class="text-danger col-md"> AGUARDANDO </p>
        </div>
    </div>
</template>


<script>
import LoginModel from "@/model/login-model"
import YesNo from "@/components/shared/Form/YesNo"
import Alert from "@/components/shared/Alert"
import Modal from '@/components/shared/Modal.vue'

export default {
    data: () => ({
        user: $session.get('user'),
        password: '',
        loading: false,
        agree: null,
        show: { password: false, button: true, },
        showModal: false,
        modal: {
            motivo: ''
        }
    }),
    props: {
        signed: '',
        id: '',
        user_id: { type: String },
        disabled: { default: false },
    },
    methods: {
        showButton() {
            this.agree = null
            this.show.button = true
            this.show.password = false
        },
        showPassword() {
            this.show.button = false
            this.show.password = true
        },
        makeReturn(agree, message = '') {
            this.$emit('signed', { user_id: this.user.id, signed: true , agree: agree, message: message })
        },
        doLogin() {
            this.loading = true
            LoginModel.doAuth({ 'id': this.user.id, 'password': this.password }).then( res => {
                if(res.status) {
                    
                    if(this.agree) {
                        this.makeReturn(this.agree)
                    } else {
                        this.showModal = true
                    }
                    
                } else {
                    Alert.Confirm(res.message)
                }
                this.loading = false
            }).catch( err => {
                this.loading = false
            })
        },
        revokeDocument() {
            this.$refs.modal.close()

            Alert.YesNo("Tem certeza que deseja negar o documento?", 
                "Ao realizar essa ação o Documento será Arquivado e Invalidado").then( res => {
                if(res) {
                    this.makeReturn(false, this.modal.motivo)
                } else {
                    this.showButton()
                }
            })
        }
    },
    components: {
        'yes-no': YesNo,
        'modal': Modal,
    }
}
</script>

<style scoped>

</style>