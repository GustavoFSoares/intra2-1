<template>
    <div>
        <div v-if="signed" class="row signature-status">
            <icon icon="check" class="text-success col-md-2"/>
            <p class="text-success col-md"> ASSINADO </p>
        </div>
        <div v-else-if="user.id == user_id && signed == false" class="row">
            <input class="form-control col-md-8" placeholder="Senha..." type="password" v-model="password" :disabled="loading">
            <div>
                <button class="btn btn-primary signed-button" :disabled="loading || !password" @click="doLogin()">
                    Assinar
                    <icon icon="spinner" spin v-if="loading"/>
                </button>
            </div>
        </div>
        <div v-else class="row signature-status">
            <icon icon="times" class="text-danger col-md-2"/>
            <p class="text-danger col-md"> AGUARDANDO </p>
        </div>
    </div>
</template>


<script>
import LoginModel from "@/model/login-model"

export default {
    data: () => ({
        user: $session.get('user'),
        password: '',
        loading: false,
    }),
    props: {
        signed: '',
        user_id: { type: String },
    },
    methods: {
        doLogin() {
            this.loading = true
            LoginModel.doAuth({ 'id': this.user.id, 'password': this.password }).then( res => {
                if(res.status) {
                    this.$emit('signed', { id: this.user.id, status: true})
                    
                    alert(`Documento Assinado por: <b>${this.user.id}</b>`)
                } else {
                    this.$emit('signed', { id: this.user.id, status: true})
                    alert(`Senha não confere`)
                }
                this.loading = false
            }).catch( err => {
                this.loading = false
            })
        }
    },
}
</script>

<style scoped>
    .signature-status {
        font-weight: bold;
    }

    .signed-button {
        margin-left: 5px;   
    }

</style>
